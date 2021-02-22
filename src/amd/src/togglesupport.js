window.onload = init;

function init() {
    $('#id_font').change(function(e) {
        const foo = $('editelementform');
        const toggler = foo.children[3];

        var buffer = document.createElement('span');
        buffer.style = 'font-family:' + e.target.value + ';';
        buffer.innerHTML = sel.toString();

        if (check(buffer)) {
            $('id_font').style.backgroundColor="red";
            toggler.style.display = "block";
        } else {
            $('id_font').style.backgroundColor="green";
            toggler.style.display = "none";
        };
    });
}

function check(strJSON) {
    /***************************
     * Valid string starts with:
     * 239, 187, 191
     ********************/
    var intCharCode0 = strJSON.charCodeAt(0);   //239
    var intCharCode1 = strJSON.charCodeAt(1);   //187
    var intCharCode2 = strJSON.charCodeAt(2);   //191

    if(intCharCode0 === 239 && intCharCode1 === 187 && intCharCode2 === 191){
        return true;
    }
    else{
        return false;
    }
}