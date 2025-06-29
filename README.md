El ambiente en que se creo y probo fue en el proporcionado por apache 3.3.0

La libreria de phpword requiere ativar las extencion zip de php 
esto se puede encontrar en el php.ini
en la linea:
";extension=zip"
se debe eliminar el ";" para activarlo, luego reiniciar el servidor apache

los archivos creados se almacenan en la carpeta /resultados
