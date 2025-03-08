const pp = document.getElementById("pp");
const pre = document.getElementById("pre");
const pph = document.getElementById("pph");

pp.addEventListener("change", (e)=>{
    const xhr = new XMLHttpRequest();
    const form = new FormData();
    form.append("file", e.target.files[0]);
    xhr.open("post", "../controller/uploadController.php", false);
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            if(xhr.responseText == 'ok'){
                pph.value = "../resources/img/"+e.target.files[0].name;
                pre.src = "../resources/img/"+e.target.files[0].name;
            }else{
                alert("Une erreur inattendu est survenue");
            }
        }
    }
    xhr.send(form)
})