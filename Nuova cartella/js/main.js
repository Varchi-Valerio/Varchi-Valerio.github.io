(function () {
  linkCollapse();
  iniAnim("subtitle")  
  accordionAuto();
  setForms();
  
 /********** animated text chars used in hero subtitle****/   
 function iniAnim(id)
    {
        var separator = "|"
        var text = document.getElementById(id);
        var words = text.dataset.words.split(separator);
        if(text.words != undefined && text.words.length>0)
            return
        text.innerText = '';
        text.words = words;
        setTimeout(setChar, 100, text, 0, 0)
    }
  function setChar(text, indWord, indChar )
    { 
        if(text.innerHTML.length >0 && indChar ==0){
              unSetChar(text, indWord, text.innerHTML.length -1);
        }
        else{
            text.innerHTML += text.words[indWord][indChar];
            indChar++;
            if (indChar < text.words[indWord].length){
                setTimeout(setChar, 100, text, indWord, indChar);
            }
            else if(indWord < text.words.length-1){
                indWord++;
                setTimeout(setChar, 900, text,  indWord, 0);
                }
                else
                    text.words='';
        }    
    }
    function unSetChar(text, ind, endChar){
        if(text.innerHTML.length > 0){
            var newText = text.innerHTML.slice(0,endChar)
            text.innerHTML = newText;
            endChar = newText.length-1;
            setTimeout(unSetChar, 100, text, ind, endChar);
            }
        else
            setChar(text, ind, 0 )
    }

/********Toggle expandable menu after click ************/
 function linkCollapse(){
    const navLinks = document.querySelectorAll('.nav-item')
    const menuToggle = document.querySelector('.collapse')
    const bsCollapse = new bootstrap.Collapse(menuToggle, {toggle:false})
    navLinks.forEach((l) => {
        l.addEventListener('click', () => { 
            if (window.innerWidth < 768) {bsCollapse.toggle()} 
          })
      })
   }

/****** Scroll event *****************/
/****** Change opacity hero **********/
/*******Reinit animation title *******/    
window.addEventListener('scroll',()=>{
   var intro = document.querySelector(".hero");
   var op = (window.pageYOffset)/window.innerHeight;
   op = Math.pow(Math.cos(op*Math.PI/2),2);
   if(op <0) return;
   intro.style.setProperty('opacity',op) ;
   home = document.getElementById("intro");
   if(window.pageYOffset == 0)
       iniAnim('subtitle')

   })    
    
function collapsed(element)
    {
        return element.classList.contains('collapsed');
    }
/**************Accordion auto expand when visible**************/    
function accordionAuto(){
    var observer = new IntersectionObserver(function(entries) {
            entries.forEach((item)=>{
                if(collapsed(item.target) && item.intersectionRatio == 1)
                    item.target.click(); //status ->expand
                if(!collapsed(item.target) && item.intersectionRatio < 1 )
                    item.target.click(); //status ->collapse
                })
    }, { root: null, rootMargin:"-30px 0px -30px 0px", threshold:1});
    // observing a target element
    var accordions = document.querySelectorAll(".accordion-button");
    accordions.forEach((item)=> observer.observe(item));
}
/************************************* Contact Form ***********************/
function setForms(){    
 var form = document.querySelector('.needs-validation') 
 form.addEventListener('submit', function (event) {
    event.preventDefault()
    if (!form.checkValidity()) {
      event.stopPropagation()
    }
    else{
      sendForm(form);    
    }
    form.classList.add('was-validated')
    }, false)
}

function sendForm(form)
{
   const data = new FormData(form);
   fetch("post.php", {method:"POST", body: data})
       .then(function(response) {
              if (!response.ok) {
                  let vnt = document.getElementById('respForm');
                  let cont = vnt.querySelector('.modal-body');
                  cont.innerHTML="<p>Parece que hubo un error. Vuelva a intentarlo en unos minutos</p>";
                  vnt=bootstrap.Modal.getOrCreateInstance(vnt);
                  vnt.show();
                  }
              return response.text();
            })
       .then(function(data) {
              
              let vnt = document.getElementById('respForm');
              let cont = vnt.querySelector('.modal-body');
              if(data == 'ok'){
                cont.innerHTML="<p>Thanks you for contacting me</p>";
              }
              else{
                cont.innerHTML="<p>Oh, There was an error. Please, try again later. "+data+"</p>";
              }
              vnt=bootstrap.Modal.getOrCreateInstance(vnt);
              vnt.show();
            })
   }
    
})()  