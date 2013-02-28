//js analysis
var _analysisPath = "/poster.php?id=";
var _analysisData = {
  topBackground: {url: "topBackground", ver: "1"},
  navGameRecom:  {url: "navGameRecom", ver: "1"},
  gameBannerLeft: {url: "gameBannerLeft", ver: "1"},
  gameBannerMiddle: {url: "gameBannerMiddle", ver: "1"},
  gameBannerRight: {url: "gameBannerRight", ver: "1"},
  indexTonLan1: {url: "indexTonLan1", ver: "1"},
  indexTonLan2: {url: "indexTonLan2", ver: "1"},
  indexFloatAD: {url: "indexFloatAD", ver: "1"},
  gameTextLink: {url: "gameTextLink", ver: "1"},
  innerfooterAD1: {url: "innerfooterAD1", ver: "1"},
  indexRightLitpic1: {url: "indexRightLitpic1", ver: "1"},
  contentRtPicAD: {url: "contentRtPicAD", ver: "1"},
  gameTopRec: {url: "gameTopRec", ver: "1"}
}

function _loadAnalysis(sKey) {
  var node = _analysisData[sKey];
  document.writeln('<script src="'+_analysisPath+node.url+'" type="text/javascript" charset="utf-8"></script>');
}