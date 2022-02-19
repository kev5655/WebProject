

var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("navbar").style.top = "0";
  } else {
    document.getElementById("navbar").style.top = "-50px";
  }
  prevScrollpos = currentScrollPos;
}

//------------------------------------------------------------------
//-------------------------PART_3_ANIMATION-------------------------
//------------------------------------------------------------------

var ImagesDay1 = [
    document.getElementById("posOfImg1D1"),
    document.getElementById("posOfImg2D1"),
    document.getElementById("posOfImg3D1"),
    document.getElementById("posOfImg4D1"),
    document.getElementById("posOfImg5D1"),
    document.getElementById("posOfImg6D1"),
    document.getElementById("posOfImg7D1"),
    document.getElementById("posOfImg8D1"),
    document.getElementById("posOfImg9D1"),
    document.getElementById("posOfImg10D1")
]

var defaultValuesOfImgDay1 = [
    ["20%", "70%"], //Position des "posOfImg1"
    ["45%", "70%"], //Position des "posOfImg2"
    ["52%", "65%"], //Position des "posOfImg3"
    ["50%", "62%"], //Position des "posOfImg4"
    ["46%", "55%"], //Position des "posOfImg5"
    ["22%", "38%"], //Position des "posOfImg6"
    ["25%", "42%"], //Position des "posOfImg7"
    ["22%", "36%"], //Position des "posOfImg8"
    ["20%", "33%"], //Position des "posOfImg9"
    ["75%", "20%"]  //Position des "posOfImg10"

]

// JQerry ist für die Animation der Bilder bei Part_3
function showImageD1(numberOfElement){
    for(let i = 0; i < ImagesDay1.length; i++){
        if(i == numberOfElement){
            // JQerry animiert das Aufploben der Bilder
            $(document).ready(function(){
                $(ImagesDay1[i]).show(1000); // 600ms
            });
        }else{ // Alle Elemente die nicht berührt werden
            if(ImagesDay1[i].style.display == "inline" || ImagesDay1[i].style.display == "inline-block"){ // Alle Elemente die noch Angezeigt werden
                // JQerry animiert das verschwinden der Bilder
                $(document).ready(function(){
                    $(ImagesDay1[i]).hide(1000, function(){ // 600ms
                        // Stellt den Defaut wert ein nach den Verschwinden des Bildes
                        ImagesDay1[i].style.width = "25%";
                        ImagesDay1[i].style.zIndex = 0;
                        ImagesDay1[i].style.top = defaultValuesOfImgDay1[i][0]
                        ImagesDay1[i].style.left = defaultValuesOfImgDay1[i][1]
                    }); 
                });
            }
            // Defautl Values beim verschwinden der Bilder
        }
    }
}

// Wird aufgerufen wen auf das Bild gecklickt wird
function zoomImageD1(numberOfElement){
    ImagesDay1[numberOfElement].style.width = "50%";
    ImagesDay1[numberOfElement].style.top = "50%";
    ImagesDay1[numberOfElement].style.left = "50%";
    ImagesDay1[numberOfElement].style.zIndex = 1001;
}


//------------------------------------------------------------------
//-------------------------PART_4_ANIMATION-------------------------
//------------------------------------------------------------------

var imagesDay2 = [
    document.getElementById("posOfImg1D2"),
    document.getElementById("posOfImg2D2"),
    document.getElementById("posOfImg3D2"),
    document.getElementById("posOfImg4D2"),
    document.getElementById("posOfImg5D2"),
    document.getElementById("posOfImg6D2"),
    document.getElementById("posOfImg7D2"),
    document.getElementById("posOfImg8D2"),
    document.getElementById("posOfImg9D2"),
    document.getElementById("posOfImg10D2")
]

var defaultValuesOfImgDay2 = [
    ["58%", "85%"], //Position des "posOfImg1"
    ["45%", "70%"], //Position des "posOfImg2"
    ["52%", "65%"], //Position des "posOfImg3"
    ["50%", "62%"], //Position des "posOfImg4"
    ["46%", "55%"], //Position des "posOfImg5"
    ["22%", "38%"], //Position des "posOfImg6"
    ["25%", "42%"], //Position des "posOfImg7"
    ["22%", "36%"], //Position des "posOfImg8"
    ["20%", "33%"], //Position des "posOfImg9"
    ["75%", "20%"]  //Position des "posOfImg10"

]

// JQerry ist für die Animation der Bilder bei Part_4
function showImageD2(numberOfElement){
    for(let i = 0; i < imagesDay2.length; i++){
        if(i == numberOfElement){
            // JQerry animiert das Aufploben der Bilder
            $(document).ready(function(){
                $(imagesDay2[i]).show(1000); // 600ms
            });
        }else{ // Alle Elemente die nicht berührt werden
            if(imagesDay2[i].style.display == "inline" || imagesDay2[i].style.display == "inline-block"){ // Alle Elemente die noch Angezeigt werden
                // JQerry animiert das verschwinden der Bilder
                $(document).ready(function(){
                    $(imagesDay2[i]).hide(1000, function(){ // 600ms
                        // Stellt den Defaut wert ein nach den Verschwinden des Bildes
                        imagesDay2[i].style.width = "25%";
                        imagesDay2[i].style.zIndex = 0;
                        imagesDay2[i].style.top = defaultValuesOfImgDay2[i][0]
                        imagesDay2[i].style.left = defaultValuesOfImgDay2[i][1]
                    }); 
                });
            }
            // Defautl Values beim verschwinden der Bilder
        }
    }
}

// Wird aufgerufen wen auf das Bild gecklickt wird
function zoomImageD2(numberOfElement){
    imagesDay2[numberOfElement].style.width = "50%";
    imagesDay2[numberOfElement].style.top = "50%";
    imagesDay2[numberOfElement].style.left = "50%";
    imagesDay2[numberOfElement].style.zIndex = 1001;
}


//------------------------------------------------------------------
//-------------------------PART_5_ANIMATION-------------------------
//------------------------------------------------------------------

var imagesDay3 = [
    document.getElementById("posOfImg1D3"),
    document.getElementById("posOfImg2D3"),
    document.getElementById("posOfImg3D3"),
    document.getElementById("posOfImg4D3"),
    document.getElementById("posOfImg5D3"),
    document.getElementById("posOfImg6D3"),
    document.getElementById("posOfImg7D3"),
    document.getElementById("posOfImg8D3"),
    document.getElementById("posOfImg9D3"),
    document.getElementById("posOfImg10D3")
]

var defaultValuesOfImgDay3 = [
    ["20%", "70%"], //Position des "posOfImg1"
    ["45%", "70%"], //Position des "posOfImg2"
    ["52%", "65%"], //Position des "posOfImg3"
    ["50%", "62%"], //Position des "posOfImg4"
    ["46%", "55%"], //Position des "posOfImg5"
    ["22%", "38%"], //Position des "posOfImg6"
    ["25%", "42%"], //Position des "posOfImg7"
    ["22%", "36%"], //Position des "posOfImg8"
    ["20%", "33%"], //Position des "posOfImg9"
    ["75%", "20%"]  //Position des "posOfImg10"

]

// JQerry ist für die Animation der Bilder bei Part_5
function showImageD3(numberOfElement){
    for(let i = 0; i < imagesDay3.length; i++){
        if(i == numberOfElement){
            // JQerry animiert das Aufploben der Bilder
            $(document).ready(function(){
                $(imagesDay3[i]).show(1000); // 600ms
            });
        }else{ // Alle Elemente die nicht berührt werden
            if(imagesDay3[i].style.display == "inline" || imagesDay3[i].style.display == "inline-block"){ // Alle Elemente die noch Angezeigt werden oder an animieren ist
                // JQerry animiert das verschwinden der Bilder
                $(document).ready(function(){
                    $(imagesDay3[i]).hide(1000, function(){ // 600ms
                        // Stellt den Defaut wert ein nach den Verschwinden des Bildes
                        imagesDay3[i].style.width = "25%";
                        imagesDay3[i].style.zIndex = 0;
                        imagesDay3[i].style.top = defaultValuesOfImgDay3[i][0]
                        imagesDay3[i].style.left = defaultValuesOfImgDay3[i][1]
                    }); 
                });
            }
            // Defautl Values beim verschwinden der Bilder
        }
    }
}

// Wird aufgerufen wen auf das Bild gecklickt wird
function zoomImageD3(numberOfElement){
    imagesDay3[numberOfElement].style.width = "50%";
    imagesDay3[numberOfElement].style.top = "50%";
    imagesDay3[numberOfElement].style.left = "50%";
    imagesDay3[numberOfElement].style.zIndex = 1001;
}


/*
function showImage1(){
    img2.style.display = "none";
    img3.style.display = "none";
    img4.style.display = "none";
    img5.style.display = "none";
    img6.style.display = "none";
    img7.style.display = "none";
    img8.style.display = "none";
    img9.style.display = "none";
    img10.style.display = "none";
    img1.style.display = "inline";
}

function showImage2(){
    img1.style.display = "none";
    img3.style.display = "none";
    img4.style.display = "none";
    img5.style.display = "none";
    img6.style.display = "none";
    img7.style.display = "none";
    img8.style.display = "none";
    img9.style.display = "none";
    img10.style.display = "none";
    img2.style.display = "inline";
}

function showImage3(){
    img1.style.display = "none";
    img2.style.display = "none";
    img4.style.display = "none";
    img5.style.display = "none";
    img6.style.display = "none";
    img7.style.display = "none";
    img8.style.display = "none";
    img9.style.display = "none";
    img10.style.display = "none";
    img3.style.display = "inline";
}

function showImage4(){
    img1.style.display = "none";
    img2.style.display = "none";
    img3.style.display = "none";
    img5.style.display = "none";
    img6.style.display = "none";
    img7.style.display = "none";
    img8.style.display = "none";
    img9.style.display = "none";
    img10.style.display = "none";
    img4.style.display = "inline";
}

function showImage5(){
    img1.style.display = "none";
    img2.style.display = "none";
    img3.style.display = "none";
    img4.style.display = "none";
    img6.style.display = "none";
    img7.style.display = "none";
    img8.style.display = "none";
    img9.style.display = "none";
    img10.style.display = "none";
    img5.style.display = "inline";
}

function showImage6(){
    img1.style.display = "none";
    img2.style.display = "none";
    img3.style.display = "none";
    img4.style.display = "none";
    img5.style.display = "none";
    img7.style.display = "none";
    img8.style.display = "none";
    img9.style.display = "none";
    img10.style.display = "none";
    img6.style.display = "inline";
}

function showImage7(){
    img1.style.display = "none";
    img2.style.display = "none";
    img3.style.display = "none";
    img4.style.display = "none";
    img5.style.display = "none";
    img6.style.display = "none";
    img8.style.display = "none";
    img9.style.display = "none";
    img10.style.display = "none";
    img7.style.display = "inline";
}


function showImage8(){
    img1.style.display = "none";
    img2.style.display = "none";
    img3.style.display = "none";
    img4.style.display = "none";
    img5.style.display = "none";
    img6.style.display = "none";
    img7.style.display = "none";
    img9.style.display = "none";
    img10.style.display = "none";
    img8.style.display = "inline";
}


function showImage9(){
    img1.style.display = "none";
    img2.style.display = "none";
    img3.style.display = "none";
    img4.style.display = "none";
    img5.style.display = "none";
    img6.style.display = "none";
    img7.style.display = "none";
    img8.style.display = "none";
    img10.style.display = "none";
    img9.style.display = "inline";
}


function showImage10(){
    img1.style.display = "none";
    img2.style.display = "none";
    img3.style.display = "none";
    img4.style.display = "none";
    img5.style.display = "none";
    img6.style.display = "none";
    img7.style.display = "none";
    img8.style.display = "none";
    img9.style.display = "none";
    img10.style.display = "inline";
}

*/