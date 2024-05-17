!function(t,e,s){"use strict";function i(t){return t.element,t.id?"<i class='"+s(t.element).data("icon")+"'></i>"+t.text:t.text}s(".select2").select2({dropdownAutoWidth:!0,width:"100%"}),s(".select2-icons").select2({dropdownAutoWidth:!0,width:"100%",minimumResultsForSearch:1/0,templateResult:i,templateSelection:i,escapeMarkup:function(t){return t}}),s(".max-length").select2({dropdownAutoWidth:!0,width:"100%",maximumSelectionLength:2,placeholder:"Select maximum 2 items"});var r=s(".js-example-programmatic").select2({dropdownAutoWidth:!0,width:"100%"}),a=s(".js-example-programmatic-multi").select2();function o(t,e){return 0===e.toUpperCase().indexOf(t.toUpperCase())}a.select2({dropdownAutoWidth:!0,width:"100%",placeholder:"Programmatic Events"}),s(".js-programmatic-set-val").on("click",function(){r.val("CA").trigger("change")}),s(".js-programmatic-open").on("click",function(){r.select2("open")}),s(".js-programmatic-close").on("click",function(){r.select2("close")}),s(".js-programmatic-init").on("click",function(){r.select2()}),s(".js-programmatic-destroy").on("click",function(){r.select2("destroy")}),s(".js-programmatic-multi-set-val").on("click",function(){a.val(["CA","AL"]).trigger("change")}),s(".js-programmatic-multi-clear").on("click",function(){a.val(null).trigger("change")}),s(".select2-data-array").select2({dropdownAutoWidth:!0,width:"100%",data:[{id:0,text:"enhancement"},{id:1,text:"bug"},{id:2,text:"duplicate"},{id:3,text:"invalid"},{id:4,text:"wontfix"}]}),s(".select2-data-ajax").select2({dropdownAutoWidth:!0,width:"100%",ajax:{url:"https://api.github.com/search/repositories",dataType:"json",delay:250,data:function(t){return{q:t.term,page:t.page}},processResults:function(t,e){return e.page=e.page||1,{results:t.items,pagination:{more:30*e.page<t.total_count}}},cache:!0},placeholder:"Search for a repository",escapeMarkup:function(t){return t},minimumInputLength:1,templateResult:function(t){if(t.loading)return t.text;var e="<div class='select2-result-repository clearfix'><div class='select2-result-repository__avatar'><img src='"+t.owner.avatar_url+"' /></div><div class='select2-result-repository__meta'><div class='select2-result-repository__title'>"+t.full_name+"</div>";return t.description&&(e+="<div class='select2-result-repository__description'>"+t.description+"</div>"),e+"<div class='select2-result-repository__statistics'><div class='select2-result-repository__forks'><i class='icon-code-fork mr-0'></i> "+t.forks_count+" Forks</div><div class='select2-result-repository__stargazers'><i class='icon-star5 mr-0'></i> "+t.stargazers_count+" Stars</div><div class='select2-result-repository__watchers'><i class='icon-eye mr-0'></i> "+t.watchers_count+" Watchers</div></div></div></div>"},templateSelection:function(t){return t.full_name||t.text}}),s.fn.select2.amd.require(["select2/compat/matcher"],function(t){s(".select2-customize-result").select2({dropdownAutoWidth:!0,width:"100%",placeholder:"Search by 'r'",matcher:t(o)})}),s(".select2-theme").select2({dropdownAutoWidth:!0,width:"100%",placeholder:"Classic Theme",theme:"classic"}),s(".select2-size-lg").select2({dropdownAutoWidth:!0,width:"100%",containerCssClass:"select-lg"}),s(".select2-size-sm").select2({dropdownAutoWidth:!0,width:"100%",containerCssClass:"select-sm"}),s(".select2-bg").each(function(t,e){var i="",r="",a=s(this).data("bgcolor");i=s(this).data("bgcolor-variation"),""!==(r=s(this).data("text-variation"))&&(r=" "+r),""!==i&&(i=" bg-"+i);var o="bg-"+a+i+" "+s(this).data("text-color")+r+" border-"+a+" border-darken-2 ";s(this).select2({dropdownAutoWidth:!0,width:"100%",containerCssClass:o})}),s(".select2-border").each(function(t,e){var i="",r="",a=s(this).data("border-color");""!==(r=s(this).data("text-variation"))&&(r=" "+r),""!==(i=s(this).data("border-variation"))&&(i=" border-"+i);var o="border-"+a+" "+i+" "+s(this).data("text-color")+r;s(this).select2({dropdownAutoWidth:!0,width:"100%",containerCssClass:o})}),s(".select2-full-bg").each(function(t,e){var i="",r="",a=s(this).data("bgcolor");""!==(i=s(this).data("bgcolor-variation"))&&(i=" bg-"+i),""!==(r=s(this).data("text-variation"))&&(r=" "+r);var o="bg-"+a+i+" "+s(this).data("text-color")+r+" border-"+a+" border-darken-2 ";s(this).select2({dropdownAutoWidth:!0,width:"100%",containerCssClass:o,dropdownCssClass:o})}),s("select[data-text-color]").each(function(t,e){var i,r=s(this).data("text-color");""!==(i=s(this).data("text-variation"))&&(i=" "+i),s(this).next(".select2").find(".select2-selection__rendered").addClass(r+i)})}(window,document,jQuery);
