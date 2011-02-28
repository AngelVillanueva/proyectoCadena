<?php

class ImagenesComponent extends Object {

    function subirImg($data, $directorio="img/", $tipo=0, $anchoMin=0, $altoMin=0, $anchoGr=0, $altoGr=0, $logo=false){

        ####################################################################

        ####################################################################

        ####    FUNCION PARA SUBIR IMAGENES AL SERVIDOR         ####

        ####    $data = Es la variable $this->data['Modulo']     ####

        ####    $directorio = El lugar donde queremos que se guarde ####

        ####    la foto, por defecto se guarda en webroot/img/      ####

        ####    $tipo= las opciones son las siguientes:         ####

        ####             0.- Sin miniatura (por defecto)        ####

        ####             1.- Con miniatura de medidas estricta      ####

        ####            (ejm si dicen 100x100 sera asi      ####

        ####            incluso deformando la imagen)       ####

        ####             2.- Con miniatura de relacion de aspecto   ####

        ####                (ejm si dicen 100x100 pero la imagen es ####

        ####            rectangular colocara uno de los lados   ####

        ####            en 100 y el otro en proporcion)     ####

        ####    $anchoMin= Ancho para las miniaturas (por defecto 0)    ####

        ####    $altoMin= Alto para las miniaturas (por defecto 0)  ####

        ####    $anchoGr= Ancho para la imagen grande (por defecto 0)   ####
        ####    $altoGr= Alto para la imagen grande (por defecto 0) ####
       ####    $logo= Ruta de el logo que deseamos colocar         ####
        ####        (solo acepta png) (por defecto false)       ####
        ####################################################################
        ####################################################################

        $archivo = md5(uniqid(rand(), true));
        $nom_foto = substr($archivo, 2, 15);
        $nombre =$nom_foto.".jpg";
       
        if (move_uploaded_file($data['tmp_name'], $directorio.$nombre)){
            $url= $nombre;

            $grande = imagecreatefromjpeg($directorio.$nombre);

            $ancho4 = imagesx($grande);

            $alto4 = imagesy($grande);

            $size = getimagesize($directorio.$nombre);

            $width=$size[0];

            $height=$size[1];

            if($altoGr == "0"){

                $newwidth = $anchoGr;

                $newheight=$height*$newwidth/$width;

            }elseif($anchoGr == "0"){

                $newheight=$altoGr;

                $newwidth = $width*$newheight/$height;

            }else{

                $newheight=$altoGr;

                $newwidth = $width*$newheight/$height;

                if($newwidth < $anchoGr){

                    $newwidth = $anchoGr;

                    $newheight=$height*$newwidth/$width;

                }

            }

            if($anchoGr != 0 and $altoGr != 0){

                $redimension = imagecreatetruecolor($newwidth,$newheight);

                imagecopyresampled($redimension,$grande,0,0,0,0,$newwidth,$newheight,$ancho4,$alto4);

                imagejpeg($redimension,$directorio.$nombre,90);

            }

 

            if($logo){

                $imagen_logo = imagecreatefrompng($logo);

                $ancho_logo = imagesx($imagen_logo);

                $alto_logo = imagesy($imagen_logo);

 

                $imagen_dest = imagecreatefromjpeg($directorio.$nombre);

                $ancho_dest = imagesx($imagen_dest);

                $alto_dest = imagesy($imagen_dest);

 

                $ancho_muestra = ($ancho_dest - $ancho_logo) - 10;

                $alto_muestra = ($alto_dest - $alto_logo) - 10;

 

                imagecopyresized($imagen_dest,$imagen_logo,$ancho_muestra,$alto_muestra,0,0,$ancho_logo,$alto_logo,$ancho_logo,$alto_logo);

                imagejpeg($imagen_dest,$directorio.$nombre,75);

            }

 

            if($tipo == "1"){

                $original = imagecreatefromjpeg($directorio.$nombre);

                $ancho = imagesx($original);

                $alto = imagesy($original);

                if($altoMin == "0"){

                    $newwidth = $anchoMin;

                    $newheight=$height*$newwidth/$width;

                }elseif($anchoMin == "0"){

                    $newheight=$altoMin;

                    $newwidth = $width*$newheight/$height;

                }else{

                    $newwidth   = $anchoMin;

                    $newheight  = $altoMin;

                }

                $thumb = imagecreatetruecolor($newwidth,$newheight);

                imagecopyresampled($thumb,$original,0,0,0,0,$newwidth,$newheight,$ancho,$alto);

                $nombrethumb = "thumb_".$nombre;

                imagejpeg($thumb,$directorio.$nombrethumb,90); // 90 es la calidad de compresión

            }elseif($tipo == 2){

                $original = imagecreatefromjpeg($directorio.$nombre);

                $ancho = imagesx($original);

                $alto = imagesy($original);

                if($altoMin == "0"){

                    $newwidth = $anchoMin;

                    $newheight=$height*$newwidth/$width;

                }elseif($anchoMin == "0"){

                    $newheight=$altoMin;

                    $newwidth = $width*$newheight/$height;

                }else{

                    $newheight=$altoMin;

                    $newwidth = $width*$newheight/$height;

                    if($newwidth > $anchoMin){

                        $newwidth = $anchoMin;

                        $newheight=$height*$newwidth/$width;

                    }

                }

 

                $thumb = imagecreatetruecolor($newwidth,$newheight);

                imagecopyresampled($thumb,$original,0,0,0,0,$newwidth,$newheight,$ancho,$alto);

                $nombrethumb = "thumb_".$nombre;

                imagejpeg($thumb,$directorio.$nombrethumb,90); // 90 es la calidad de compresión

            }

            return $url;

        }else{

            $url="";

            return $url;

        }

    }

}

 

?>
