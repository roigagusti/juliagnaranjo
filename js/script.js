/*
# Author: Aldasoro
# Template: Julia G. Naranjo
# Version: 2.0
# Copyright 2018 Aldasoro, inc.
# www: http://www.agustiroig.com


Taula de continguts
-------------------
1. Email
*/

usuario="julia" 
dominio="juliagnaranjo.com" 
conector="@" 


function correo(){ 
   return usuario + conector + dominio 
} 

function enlace_correo(){ 
   document.write("<a href='mailto:" + correo() + "'>" + correo() + "</a>") 
}