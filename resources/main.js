const picBtn1 = document.querySelector("#img1");
const picBtn2 = document.querySelector("#img2");
const picBtn3 = document.querySelector("#img3");
const picBtn4 = document.querySelector("#img4");
const cimg1 = document.querySelector("#cimg1");
const cimg2 = document.querySelector("#cimg2");
const cimg3 = document.querySelector("#cimg3");
const cimg4 = document.querySelector("#cimg4");
const prev1 = document.querySelector(".prev1");
const prev2 = document.querySelector(".prev2");
const prev3 = document.querySelector(".prev3");
const prev4 = document.querySelector(".prev4");

picBtn1.addEventListener("change", (e)=>{
    const xhr = new XMLHttpRequest();
    const form = new FormData();
    form.append("file", e.target.files[0]);
    xhr.open("post", "../controller/uploadController.php", false);
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            if(xhr.responseText == 'ok'){
                cimg1.value = "../resources/img/"+e.target.files[0].name;
                prev1.style.backgroundImage = "url(../resources/img/"+e.target.files[0].name+")";
            }else{
                alert("Une erreur inattendu est survenue");
            }
        }
    }
    xhr.send(form)  
})
picBtn2.addEventListener("change", (e)=>{
    const xhr = new XMLHttpRequest();
    const form = new FormData();
    form.append("file", e.target.files[0]);
    xhr.open("post", "../controller/uploadController.php", false);
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            if(xhr.responseText == 'ok'){
                cimg2.value = "../resources/img/"+e.target.files[0].name;
                prev2.style.backgroundImage = "url(../resources/img/"+e.target.files[0].name+")";
            }else{
                alert("Une erreur inattendu est survenue");
            }
        }
    }
    xhr.send(form)  
})
picBtn3.addEventListener("change", (e)=>{
    const xhr = new XMLHttpRequest();
    const form = new FormData();
    form.append("file", e.target.files[0]);
    xhr.open("post", "../controller/uploadController.php", false);
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            if(xhr.responseText == 'ok'){
                cimg3.value = "../resources/img/"+e.target.files[0].name;
                prev3.style.backgroundImage = "url(../resources/img/"+e.target.files[0].name+")";
            }else{
                alert("Une erreur inattendu est survenue");
            }
        }
    }
    xhr.send(form)  
})
picBtn4.addEventListener("change", (e)=>{
    const xhr = new XMLHttpRequest();
    const form = new FormData();
    form.append("file", e.target.files[0]);
    xhr.open("post", "../controller/uploadController.php", false);
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            if(xhr.responseText == 'ok'){
                cimg4.value = "../resources/img/"+e.target.files[0].name;
                prev4.style.backgroundImage = "url(../resources/img/"+e.target.files[0].name+")";
            }else{
                alert("Une erreur inattendu est survenue");
            }
        }
    }
    xhr.send(form)  
})
