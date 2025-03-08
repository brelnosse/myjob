const methods = document.querySelectorAll("input[name='operator']"); 
const meths = ['MTN', 'ORANGE'];
const tel = document.getElementById("num_tel");

function checkMethod(){
    let meth;
    for(let elem of methods){
        if(elem.checked){
            meth = elem.value;
        }
    }
    if(meths.includes(meth)){
        return true;
    }
}
function checkPhone(phone){
    if(/^6[0-9]{8}$/.test(phone)){
        return true;
    }else{
         return false;
    }
}

