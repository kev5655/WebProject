console.log("Hello Welt");

//------------------------------------------------------------------
//----------------------Load on Scroll for IMG----------------------
//------------------------------------------------------------------

// link: https://stackoverflow.com/questions/5117421/how-to-load-images-dynamically-or-lazily-when-users-scrolls-them-into-view
// Funktioniert mit JQerry

// Wen gescrolt wird
$(window).scroll(function() { 
    // Holt sich alle HTML-Tag's mit 'img'
    $.each($('img'), function() { 
        // Alle img werden beim Ersten scrollen geladen
        if ( $(this).attr('data-src') && 
        $(this).offset().top < ($(window).scrollTop() + $(window).height()) ) {
            // Holt sich die gespeicherte Source von 'data-src',
            // in 'data-src' liegt der Link zum Bild
            var source = $(this).data('src'); 
            // Überschreibt did leeren HTML-Tag's 'src' mit den 'data-src' Tag's
            $(this).attr('src', source); 
            // Löscht die 'data-src' Tag's
            $(this).removeAttr('data-src'); 
        }
    })
})



//------------------------------------------------------------------
//-------------------------PART_1_ANIMATION-------------------------
//------------------------------------------------------------------

// Navigationsbar nach unten Scrollen lässt die Navigationsbar verschwinden
// nach oben Scrollen lässt die Navigationsbar anzeigen

// Gibt die Position des Y-Offest an
var prevScrollpos = window.pageYOffset;
// Wenn gescrollt wird
window.onscroll = function() {
    // Fragt die neue Y-Offest-Position nach dem Scrollen ab
    var currentScrollPos = window.pageYOffset;
    // Wen die aktuelle Position unter den Y-Offest der Webseite liegt
    // soll die Navigationsbar am oberen Bild Rand angezeigt werden
    if (prevScrollpos > currentScrollPos) {
        // Lässt die Navigatonsbar erscheine
        document.getElementById("navbar").style.top = "0";
    }else{ 
        // Lässt die Navigatonsbar verschwinden
        document.getElementById("navbar").style.top = "-200px";
    }
    // Schreib die aktuelle Position in die vorige Position, um Flackern zu verbinden
    prevScrollpos = currentScrollPos;
}


//------------------------------------------------------------------
//-------------------------PART_3_ANIMATION-------------------------
//------------------------------------------------------------------

// Holt das HTML Element
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

// Default Werte der Positionen der Bilder
var defaultValuesOfImgDay1 = [
    ["20%", "70%"], //Position des "posOfImg1"
    ["45%", "70%"], //Position des "posOfImg2"
    ["52%", "65%"], //Position des "posOfImg3"
    ["50%", "62%"], //Position des "posOfImg4"
    ["46%", "55%"], //Position des "posOfImg5"
    ["25%", "42%"], //Position des "posOfImg6"
    ["22%", "38%"], //Position des "posOfImg7"
    ["22%", "36%"], //Position des "posOfImg8"
    ["20%", "33%"], //Position des "posOfImg9"
    ["75%", "20%"]  //Position des "posOfImg10"
]

// Funkton benutzt jQuery für die Bilder Animation
function showImageD1(numberOfElement){
    // Iteriert durch alle Bilder
    for(let i = 0; i < ImagesDay1.length; i++){
        
        if(i == numberOfElement){
            // JQerry animiert das Aufrufen der Bilder dauert 600ms
            $(document).ready(function(){
                $(ImagesDay1[i]).show(600);
            });
        }
        
        else{ // Alle Elemente, die nicht berührt werden
            
            // Alle Elemente die noch Angezeigt werden
            if(ImagesDay1[i].style.display == "inline" || 
            ImagesDay1[i].style.display == "inline-block"){ 

                // JQerry animiert, das Verschwinden der Bilder dauert 600 ms
                $(document).ready(function(){
                    
                    $(ImagesDay1[i]).hide(600, function(){ 
                        // Stellt den Default-Wert ein nach dem Verschwinden des 
                        // Bildes
                        ImagesDay1[i].style.width = "25%";
                        ImagesDay1[i].style.zIndex = 0;
                        ImagesDay1[i].style.top = defaultValuesOfImgDay1[i][0]
                        ImagesDay1[i].style.left = defaultValuesOfImgDay1[i][1]
                    }); 
                });
            }
        }
    }
}

// Wird aufgerufen wen auf das Bild gecklickt wird
function zoomImageD1(numberOfElement){
    ImagesDay1[numberOfElement].style.width = "100%";
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
    ["63%", "83%"], //Position des "posOfImg2"
    ["67%", "78%"], //Position des "posOfImg3"
    ["69%", "75%"], //Position des "posOfImg4"
    ["69%", "75%"], //Position des "posOfImg5"
    ["72%", "63%"], //Position des "posOfImg6"
    ["37%", "28%"], //Position des "posOfImg7"
    ["40%", "25%"], //Position des "posOfImg8"
    ["44%", "20%"], //Position des "posOfImg9"
    ["48%", "15%"]  //Position des "posOfImg10"

]

// JQerry ist für die Animation der Bilder bei Part_4
function showImageD2(numberOfElement){
    for(let i = 0; i < imagesDay2.length; i++){
        if(i == numberOfElement){
            // JQerry animiert das Aufrufen der Bilder dauert 600ms
            $(document).ready(function(){
                $(imagesDay2[i]).show(600);
            });
        }else{ // Alle Elemente, die nicht berührt werden
            if(imagesDay2[i].style.display == "inline" || imagesDay2[i].style.display == "inline-block"){ // Alle Elemente die noch Angezeigt werden
                // JQerry animiert, das Verschwinden der Bilder dauert 600 ms
                $(document).ready(function(){
                    $(imagesDay2[i]).hide(600, function(){
                        // Stellt den Default-Wert ein nach dem Verschwinden des Bildes
                        imagesDay2[i].style.width = "25%";
                        imagesDay2[i].style.zIndex = 0;
                        imagesDay2[i].style.top = defaultValuesOfImgDay2[i][0]
                        imagesDay2[i].style.left = defaultValuesOfImgDay2[i][1]
                    }); 
                });
            }
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
    ["22%", "42%"], //Position des "posOfImg6"
    ["25%", "40%"], //Position des "posOfImg7"
    ["22%", "36%"], //Position des "posOfImg8"
    ["20%", "30%"], //Position des "posOfImg9"
    ["22%", "25%"]  //Position des "posOfImg10"

]

// JQerry ist für die Animation der Bilder bei Part_5
function showImageD3(numberOfElement){
    for(let i = 0; i < imagesDay3.length; i++){
        if(i == numberOfElement){
            // JQerry animiert das Aufrufen der Bilder dauert 600ms
            $(document).ready(function(){
                $(imagesDay3[i]).show(600); 
            });
        }else{ // Alle Elemente, die nicht berührt werden
            if(imagesDay3[i].style.display == "inline" || imagesDay3[i].style.display == "inline-block"){ // Alle Elemente die noch Angezeigt werden oder an animieren ist
                // JQerry animiert, das Verschwinden der Bilder dauert 600 ms
                $(document).ready(function(){
                    $(imagesDay3[i]).hide(600, function(){ 
                        // Stellt den Default-Wert ein nach dem Verschwinden des Bildes
                        imagesDay3[i].style.width = "25%";
                        imagesDay3[i].style.zIndex = 0;
                        imagesDay3[i].style.top = defaultValuesOfImgDay3[i][0]
                        imagesDay3[i].style.left = defaultValuesOfImgDay3[i][1]
                    }); 
                });
            }
        }
    }
}

// Wird aufgerufen, wen auf das Bild angeklickt wird
function zoomImageD3(numberOfElement){
    imagesDay3[numberOfElement].style.width = "50%";
    imagesDay3[numberOfElement].style.top = "50%";
    imagesDay3[numberOfElement].style.left = "50%";
    imagesDay3[numberOfElement].style.zIndex = 1001;
}

