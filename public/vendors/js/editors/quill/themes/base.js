import extend from"extend";import Delta from"rich-text/lib/delta";import Emitter from"../core/emitter";import Keyboard from"../modules/keyboard";import Theme from"../core/theme";import ColorPicker from"../ui/color-picker";import IconPicker from"../ui/icon-picker";import Picker from"../ui/picker";import Tooltip from"../ui/tooltip";import icons from"../ui/icons";const ALIGNS=[!1,"center","right","justify"],COLORS=["#000000","#e60000","#ff9900","#ffff00","#008a00","#0066cc","#9933ff","#ffffff","#facccc","#ffebcc","#ffffcc","#cce8cc","#cce0f5","#ebd6ff","#bbbbbb","#f06666","#ffc266","#ffff66","#66b966","#66a3e0","#c285ff","#888888","#a10000","#b26b00","#b2b200","#006100","#0047b2","#6b24b2","#444444","#5c0000","#663d00","#666600","#003700","#002966","#3d1466"],FONTS=[!1,"serif","monospace"],HEADERS=["1","2","3",!1],SIZES=["small",!1,"large","huge"];class BaseTheme extends Theme{constructor(t,e){super(t,e);let i=e=>{if(!document.body.contains(t.root))return document.body.removeEventListener("click",i);null==this.tooltip||this.tooltip.root.contains(e.target)||document.activeElement===this.tooltip.textbox||this.quill.hasFocus()||this.tooltip.hide(),null!=this.pickers&&this.pickers.forEach(function(t){t.container.contains(e.target)||t.close()})};document.body.addEventListener("click",i)}addModule(t){let e=super.addModule(t);return"toolbar"===t&&this.extendToolbar(e),e}buildButtons(t){t.forEach(t=>{(t.getAttribute("class")||"").split(/\s+/).forEach(e=>{if(e.startsWith("ql-")&&(e=e.slice("ql-".length),null!=icons[e]))if("direction"===e)t.innerHTML=icons[e][""]+icons[e].rtl;else if("string"==typeof icons[e])t.innerHTML=icons[e];else{let i=t.value||"";null!=i&&icons[e][i]&&(t.innerHTML=icons[e][i])}})})}buildPickers(t){this.pickers=t.map(t=>{if(t.classList.contains("ql-align"))return null==t.querySelector("option")&&fillSelect(t,ALIGNS),new IconPicker(t,icons.align);if(t.classList.contains("ql-background")||t.classList.contains("ql-color")){let e=t.classList.contains("ql-background")?"background":"color";return null==t.querySelector("option")&&fillSelect(t,COLORS,"background"===e?"#ffffff":"#000000"),new ColorPicker(t,icons[e])}return null==t.querySelector("option")&&(t.classList.contains("ql-font")?fillSelect(t,FONTS):t.classList.contains("ql-header")?fillSelect(t,HEADERS):t.classList.contains("ql-size")&&fillSelect(t,SIZES)),new Picker(t)});let e=()=>{this.pickers.forEach(function(t){t.update()})};this.quill.on(Emitter.events.SELECTION_CHANGE,e).on(Emitter.events.SCROLL_OPTIMIZE,e)}}BaseTheme.DEFAULTS=extend(!0,{},Theme.DEFAULTS,{modules:{toolbar:{handlers:{formula:function(t){this.quill.theme.tooltip.edit("formula")},image:function(t){let e=this.container.querySelector("input.ql-image[type=file]");null==e&&((e=document.createElement("input")).setAttribute("type","file"),e.setAttribute("accept","image/*"),e.classList.add("ql-image"),e.addEventListener("change",()=>{if(null!=e.files&&null!=e.files[0]){let t=new FileReader;t.onload=(t=>{let i=this.quill.getSelection(!0);this.quill.updateContents((new Delta).retain(i.index).delete(i.length).insert({image:t.target.result}),Emitter.sources.USER),e.value=""}),t.readAsDataURL(e.files[0])}}),this.container.appendChild(e)),e.click()},video:function(t){this.quill.theme.tooltip.edit("video")}}}}});class BaseTooltip extends Tooltip{constructor(t,e){super(t,e),this.textbox=this.root.querySelector('input[type="text"]'),this.listen()}listen(){this.textbox.addEventListener("keydown",t=>{Keyboard.match(t,"enter")?(this.save(),t.preventDefault()):Keyboard.match(t,"escape")&&(this.cancel(),t.preventDefault())})}cancel(){this.hide()}edit(t="link",e=null){this.root.classList.remove("ql-hidden"),this.root.classList.add("ql-editing"),null!=e?this.textbox.value=e:t!==this.root.getAttribute("data-mode")&&(this.textbox.value=""),this.position(this.quill.getBounds(this.quill.selection.savedRange)),this.textbox.select(),this.textbox.setAttribute("placeholder",this.textbox.getAttribute(`data-${t}`)||""),this.root.setAttribute("data-mode",t)}restoreFocus(){let t=this.quill.root.scrollTop;this.quill.focus(),this.quill.root.scrollTop=t}save(){let t=this.textbox.value;switch(this.root.getAttribute("data-mode")){case"link":let e=this.quill.root.scrollTop;this.linkRange?(this.quill.formatText(this.linkRange,"link",t,Emitter.sources.USER),delete this.linkRange):(this.restoreFocus(),this.quill.format("link",t,Emitter.sources.USER)),this.quill.root.scrollTop=e;break;case"video":let i=t.match(/^(https?):\/\/(www\.)?youtube\.com\/watch.*v=([a-zA-Z0-9_-]+)/)||t.match(/^(https?):\/\/(www\.)?youtu\.be\/([a-zA-Z0-9_-]+)/);i?t=i[1]+"://www.youtube.com/embed/"+i[3]+"?showinfo=0":(i=t.match(/^(https?):\/\/(www\.)?vimeo\.com\/(\d+)/))&&(t=i[1]+"://player.vimeo.com/video/"+i[3]+"/");case"formula":let o=this.quill.getSelection(!0),l=o.index+o.length;null!=o&&(this.quill.insertEmbed(l,this.root.getAttribute("data-mode"),t,Emitter.sources.USER),"formula"===this.root.getAttribute("data-mode")&&this.quill.insertText(l+1," ",Emitter.sources.USER),this.quill.setSelection(l+2,Emitter.sources.USER))}this.textbox.value="",this.hide()}}function fillSelect(t,e,i=!1){e.forEach(function(e){let o=document.createElement("option");e===i?o.setAttribute("selected","selected"):o.setAttribute("value",e),t.appendChild(o)})}export{BaseTooltip,BaseTheme as default};
