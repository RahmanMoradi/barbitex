Dropzone.options.profilePicUpload={paramName:"file",maxFiles:1,init:function(){this.on("maxfilesexceeded",function(i){this.removeAllFiles(),this.addFile(i)})}};
