//js analysis
var _analysisPath = "http://cdn.img.dbplay.com/userfiles/advert/";
var _analysisData = {
  topBackground: {url: "topBackground.js", ver: "1"},
  navGameRecom:  {url: "navGameRecom.js", ver: "1"},
  gameBannerLeft: {url: "gameBannerLeft.js", ver: "1"},
  gameBannerMiddle: {url: "gameBannerMiddle.js", ver: "1"},
  gameBannerRight: {url: "gameBannerRight.js", ver: "1"},
  indexTonLan1: {url: "indexTonLan1.js", ver: "1"},
  indexTonLan2: {url: "indexTonLan2.js", ver: "1"},
  indexFloatAD: {url: "indexFloatAD.js", ver: "1"},
  gameTextLink: {url: "gameTextLink.js", ver: "1"},
  innerfooterAD1: {url: "innerfooterAD1.js", ver: "1"},
  indexRightLitpic1: {url: "indexRightLitpic1.js", ver: "1"},
  contentRtPicAD: {url: "contentRtPicAD.js", ver: "1"},
  gameTopRec: {url: "gameTopRec.js", ver: "1"}
}

function _loadAnalysis(sKey) {
  var node = _analysisData[sKey];
  document.writeln('<script src="'+_analysisPath+node.url+'?ver='+node.ver+'" type="text/javascript" charset="utf-8"></script>');
}