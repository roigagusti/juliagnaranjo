/*
# Author: ldrs
# Template: Hijos de Jose Maria
# Version: 1.0
# Copyright 2018 Aldasoro, Inc.
# www: http://www.hijosdejosemaria.com


Taula de continguts
-------------------
1.None*/

function showContact(){
  if($('div.compra-personalizada').hasClass('hidden')){
    $('div.compra-personalizada').removeClass('hidden');
  }else{
    $('div.compra-personalizada').addClass('hidden');
  }
}

document.getElementById("hjmEmail").onclick = function() {
    window.location.replace('mailto:"hijosdejosemaria@gmail.com"?subject=Contacto web');
}
document.getElementById("hjmLlamar").onclick = function() {
    window.location.replace('tel:+34‭687401970‬');
}