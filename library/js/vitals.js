(function(){
if(!('sendBeacon' in navigator)) return;
var data={url:location.href};
var nav=performance.getEntriesByType('navigation')[0];
if(nav) data.ttfb=nav.responseStart;
var lcp;
try{
var obs=new PerformanceObserver(function(list){var e=list.getEntries();lcp=e[e.length-1].startTime;});
obs.observe({type:'largest-contentful-paint',buffered:true});
}catch(e){}
function send(){data.lcp=lcp;navigator.sendBeacon('/ai/v1/vitals',JSON.stringify(data));}
addEventListener('visibilitychange',function(){if(document.visibilityState==='hidden')send();});
addEventListener('pagehide',send);
})();
