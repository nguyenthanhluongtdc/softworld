function toFavorite(toURL,toStr){
    if(navigator.userAgent.indexOf("MSIE") > -1){ //Internet Explorer
        window.external.AddFavorite(toURL,toStr);
    }else if(navigator.userAgent.indexOf("Lunascape") > -1){ //Lunascape
        alert("[Ctrl]と[G}ボタンを同時に押してください。");
    }else if(navigator.userAgent.indexOf("Flock") > -1){ //Flock
        window.sidebar.addPanel(toStr,toURL,'');
    }else if(navigator.userAgent.indexOf("Firefox") > -1){ //Firefox
        window.sidebar.addPanel(toStr,toURL,'');
    }else if(navigator.userAgent.indexOf("Opera") > -1){ //Opera
        window.open(toURL,'sidebar','title='+toStr);
    }else if(navigator.userAgent.indexOf("Chrome") > -1){ //Chrome,Safari
        alert("ブラウザ付属のブックマーク機能をご利用ください。[Ctrl]と[D]ボタンを同時に押すと簡単にブックマークできます");
    }else{ //その他
        alert("ブラウザ付属のブックマーク機能をご利用ください。");
    }
}