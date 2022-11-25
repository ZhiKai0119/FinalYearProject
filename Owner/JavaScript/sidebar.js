//const body = document.querySelector("body"),
//      modeToggle = body.querySelector(".mode-toggle");
//      sidebar = body.querySelector("nav");
//      sidebarToggle = body.querySelector(".sidebar-toggle");
//
//let getMode = localStorage.getItem("mode");
//if(getMode && getMode ==="dark"){
//    body.classList.toggle("dark");
//}
//
//let getStatus = localStorage.getItem("status");
//if(getStatus && getStatus ==="close"){
//    sidebar.classList.toggle("close");
//}
//
//modeToggle.addEventListener("click", () =>{
//    body.classList.toggle("dark");
//    if(body.classList.contains("dark")){
//        localStorage.setItem("mode", "dark");
//    }else{
//        localStorage.setItem("mode", "light");
//    }
//});
//
//sidebarToggle.addEventListener("click", () => {
//    sidebar.classList.toggle("close");
//    if(sidebar.classList.contains("close")){
//        localStorage.setItem("status", "close");
//    }else{
//        localStorage.setItem("status", "open");
//    }
//})

let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e)=>{
    let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
    arrowParent.classList.toggle("showMenu");
    });
}
let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu");
console.log(sidebarBtn);
sidebarBtn.addEventListener("click", ()=>{
sidebar.classList.toggle("close");
});