<?php
/**
 * Tag类的一些函数
 *
 */

/**
 * 向tag系统中加入/删除一个tag
 * 
 * @param string $tagname Tag名
 * @param integer $aid 文章的ID
 * @param integer $typeid 文章类型ID
 * @param string $type  tag的类型  tag/category
 * @param string $action tag的操作动作 add / delete
 */
function zq_tag($tagname, $aid, $typeid, $type = 'tag', $action='add') {
    $tagid = getTagIdByName($tagname);
    //新增没有的话 尝试加入
    $taxonomyId = getTaxonomyId($tagid, $type);

    if ($taxonomyId) {
	if ($action == 'add') {
	    addTagRelationship($aid, $taxonomyId, $typeid);
	} elseif ($action == 'update') {
	    deleteTagRelationship($aid, $typeid, false);
	    addTagRelationship($aid, $taxonomyId, $typeid);
	} elseif ($action == 'delete') {
	    deleteTagRelationship($aid, $typeid, $taxonomyId);
	}
    }
}

/**
 * 根据tagname获得tag id
 *
 * @param string $tagname Tag名称
 */
function getTagIdByName($tagname) {
    $db = zq_core::load_model('tag_model');
    
    $tagname = trim($tagname);

    $r = $db->get_one(array(
	'name' => $tagname
    ));

    if (!empty($r) && is_array($r)) {
	return $r['id'];
    } else {
	$tagid = $db->insert(
	    array(
		'name' => $tagname
	    ), true
	);
	return $tagid;
    }
}

/**
 * 根据tagid获得tag信息
 */
function getTagInfoById($tagid) {
    $db = zq_core::load_model('tag_model');

    $tagid = intval($tagid);
    return $db->get_one(array('id'=>$tagid));
}

/**
 * 获得真实的tag id
 */
function getTaxonomyId($tagid, $type, $readonly=false) {
    $tag = getTagInfoById($tagid);
    if (empty($tag)) {
	return false;
    }

    $db = zq_core::load_model('tag_taxonomy_model');
    $r = $db->get_one(
	array(
	    'tag_id' => $tagid,
	    'taxonomy'=>$type
	)
    );

    if (!empty($r) && is_array($r)){
	return $r['id'];
    } else {
	$taxonomyId = $db->insert(
	    array(
		'tag_id'=>$tagid,
		'taxonomy'=>$type
	    ), true
	);

	return $taxonomyId;
    }
}

/**
 * 增加/降低taxonomy计数
 *
 * @param integer $taxonomy 
 * @param boolean $isaddication 增加还是降低
 */
function updateTaxonomyCount($taxonomyId, $isaddication) {
    $db = zq_core::load_model('tag_taxonomy_model');
    $r = $db->get_one(array('id'=>$taxonomyId));

    if (!empty($r) && is_array($r)) {
	$sql = array();
	if ($isaddication) {
	    $sql['count']= '+=1';
	} else {
	    $sql['count']= '-=1';
	}
	
	$db->update(
	    $sql,
	    array(
		'id' => $taxonomyId
	    )
	);
    }
    return false;
}

/**
 * 增加关系id数据
 */
function addTagRelationship($aid, $taxonomyId, $typeid) {
    $db = zq_core::load_model('tag_relationship_model');

    $r = $db->get_one(
	array(
	    'aid' => $aid,
	    'tag_taxonomy_id' => $taxonomyId,
	    'typeid' => $typeid
	)
    );
    if (empty($r)) {
	$issucces = $db->insert(
	    array(
		'aid' => $aid,
		'tag_taxonomy_id' => $taxonomyId,
		'typeid' => $typeid
	    )
	);
	
	if ($issucces) {
	    //更新计数
	    updateTaxonomyCount($taxonomyId, true);
	}

	return $issucces;
    }
}

/**
 * 删除关系数据id
 *
 */
function deleteTagRelationship($aid, $typeid, $taxonomyId=false) {
    $db = zq_core::load_model('tag_relationship_model');
    if (gettype($taxonomyId) == 'boolean' && $taxonomyId === false) {
	//移除所有关系
	$data = $db->select(array(
	    'aid' => $aid,
	    'typeid' => $typeid
	));

	if (!empty($data) && is_array($data)) {
	    for ($i =0; $i < count($data); $i++) {
		deleteTagRelationship($data[$i]['aid'], $data[$i]['typeid'], $data[$i]['tag_taxonomy_id']);
	    }
	}
    } elseif ($taxonomyId = intval($taxonomyId)) {
	$issucces = $db->delete(
	    array(
		'aid' => $aid,
		'tag_taxonomy_id' => $taxonomyId,
		'typeid' => $typeid
	    )
	);

	if ($issucces) {
	    updateTaxonomyCount($taxonomyId, false);
	}
    }
}


/**
 * 根据tagname 获得文章列表数据
 * @param string tagname
 * @param string taxonomy  但设置*时 获得tag,category的数据
 * @param integer typeid 内容模型id
 */
function getIdsByTagname($tagname, $taxonomy='*', $typeid) {
    $tagid = getTagIdByName($tagname);
    $ids = array();
    if ($tagid) {
	$taxonomyIds = array();
	if ($taxonomy == '*' ) {
	    $taxonomyIds[] = getTaxonomyId($tagid, 'category');
	    $taxonomyIds[] = getTaxonomyId($tagid, 'tag');
	} elseif ($taxonomy == 'category' || $taxonomy == 'tag') {
	    $taxonomyIds[] = getTaxonomyId($tagid, $taxonomy);
	}

	if (!empty($taxonomyId)) {
	    $db = zq_core::load_model('tag_relationship_model');
	    $where = array();
	    foreach ($taxonomyIds as $taxonomyId) {
		$where[] = array(
		    'tag_taxonomy_id' => $taxonomyId
		);
	    }

	    $where = join(' or ', $where);
	    $where .= $where . ' AND ' . 'typeid='.$typeid;

	    return $db->select($where, 'aid');
	}
    }

    return $ids;
}

?>
