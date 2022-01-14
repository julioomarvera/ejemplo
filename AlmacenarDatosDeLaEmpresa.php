<?php
include_once 'ConexionBase.php';
$id_municipal = "";
session_start();

if(!isset( $_SESSION["nombreCompleto"])){
    header("location: Bienvenido.php?error=1&nom_variable=1");
}
else {
    date_default_timezone_set("America/Mexico_City");
    $horaActual = date('Y-m-d H:i:s');
    $DescripcionEmpresa = "";

    if(!isset($_SESSION['nombreCompleto'])){
        $nombreCompleto = "";
    }
    else{
        $nombreCompleto = $_SESSION['nombreCompleto'];
    }
    if(!isset($_SESSION['id_NuevosUsuario'])){
        $Id = "";
    }
    else{
        $Id = $_SESSION['id_NuevosUsuario'];
    }
    if(!isset($_SESSION['usuarioActivos_NuevosUsuario'])){
        $UsuarioActivo = "";
    }
    else{
        $UsuarioActivo = $_SESSION['usuarioActivos_NuevosUsuario'];
    }
    if(!isset($_SESSION['id_Tramite'])){
        $idTramite = "";
    }
    else{
        $idTramite = $_SESSION['id_Tramite'];
    }
    if(!isset($_SESSION['Id_Usuario'])){
        $Id_Usuario = "";
    }
    else{
        $Id_Usuario = $_SESSION['Id_Usuario'];
    }
    if(!isset($_SESSION['tipoTramite'])){
        $tipoTramite = "";
    }
    else{
        $tipoTramite = $_SESSION['tipoTramite'];
    }
    if(isset($_SESSION["Efirma"])) {
        $Efirma = $_SESSION["Efirma"];
    }
    else {
        $Efirma = "";
    }




    if (isset($_POST['sel1'])){
        $CatalogoMunicipal = $_POST['sel1'];
    }
    else{
        if (isset($_POST['inputSet1'])){
            $CatalogoMunicipal =   $_POST['inputSet1'];
        }
        else{
            $CatalogoMunicipal = "";
        }
    }

    if (isset($_POST['sel2'])){
        $GiroCatalogoMunicipal = $_POST['sel2'];
        //echo die ($GiroCatalogoMunicipal);
    }
    else{
        if (isset($_POST['inputSet2'])){
            $GiroCatalogoMunicipal =   $_POST['inputSet2'];
        }
        else{
            $GiroCatalogoMunicipal = "";
        }
    }

    if (isset($_POST['descActividadInput'])){
        $DescripcionEmpresa = $_POST['descActividadInput'];
        //echo die ($GiroCatalogoMunicipal);
    }
    else{
       $DescripcionEmpresa = "";
    }

    //echo die ($descActividad);



    



if($CatalogoMunicipal != ""){
    $queryObternerIdMunicipal = "SELECT id_municipal 
                                FROM  cat_municipal 
                                WHERE nombre = '$CatalogoMunicipal'";
    $resultObternerIdMunicipal = mysqli_query($dbconexionBase, $queryObternerIdMunicipal);
    if (!$resultObternerIdMunicipal) {
        header("location: Bienvenido.php?errorConfirmacion=1&nom_variable=3");
    } 
    else {
        $num_rowsObternerIdMunicipal = mysqli_num_rows($resultObternerIdMunicipal);
        if ($num_rowsObternerIdMunicipal > 0) {
            $rw_resultadoObternerIdMunicipal = mysqli_fetch_array($resultObternerIdMunicipal);
            $id_municipal = $rw_resultadoObternerIdMunicipal['id_municipal'];
        }
    }
}






//     echo die($CatalogoMunicipal);
    if ($CatalogoMunicipal != "" && $GiroCatalogoMunicipal != "" && $id_municipal != ""){
        if ($Efirma == 1) {
            $queryObtenerDescipcion = "SELECT descripcion FROM catalogo_nuevo WHERE id_municipal = $id_municipal  and  nombre  = '$GiroCatalogoMunicipal'";
            $result = mysqli_query($dbconexionBase, $queryObtenerDescipcion);
            if (!$result) {
                header("location: Bienvenido.php?errorConfirmacion=1&nom_variable=3");
            } else {
                $num_rows = mysqli_num_rows($result);
                if ($num_rows > 0) {
                    $rw_resultado = mysqli_fetch_array($result);
                    $DescripcionEmpresa = $rw_resultado['descripcion'];

                }
            }
        }
        else{
            $queryFecha = "SELECT FechaCreacionTramite 
                           FROM   tramites 
                           WHERE  id_tramite = $idTramite ";    
            $resultadoFecha = mysqli_query($dbconexionBase, $queryFecha);
            if (!$resultadoFecha) {
                header("location: Bienvenido.php?errorConfirmacion=1&nom_variable=3");
            } else {
                $num_rowsFecha = mysqli_num_rows($resultadoFecha);
                if($num_rowsFecha > 0){
                    $rw_queryFecha = mysqli_fetch_object($resultadoFecha);
                    $FechaCreacionTramite = $rw_queryFecha->FechaCreacionTramite;
                     if($FechaCreacionTramite != ""){
                        $FechaCreacion = substr($FechaCreacionTramite,0,4);
                    }
                }
            }


            if($FechaCreacion >= 2018){

                $queryObtenerDescipcion = "SELECT descripcion FROM cat_giro2018  WHERE id_municipal = $id_municipal  and nombre = '$GiroCatalogoMunicipal'";
                //echo die ($queryObtenerDescipcion);
            }
            else{
                $queryObtenerDescipcion = "SELECT descripcion FROM cat_giro  WHERE id_municipal = $id_municipal  and nombre = '$GiroCatalogoMunicipal'";
            }
            $result = mysqli_query($dbconexionBase, $queryObtenerDescipcion);
            if (!$result) {

                header("location: Bienvenido.php?errorConfirmacion=1&nom_variable=3");
            } else {
                $num_rows = mysqli_num_rows($result);
                if ($num_rows > 0) {
                    $rw_resultado = mysqli_fetch_array($result);
                    $DescripcionEmpresa = $rw_resultado['descripcion'];
                    //echo die ($DescripcionEmpresa);

                }
            }
        }
    }

//    $DescripcionEmpresa = $_POST['descriptionActividad'];

    $ActividadPreponderable = $_POST['giro_preponderante_empresa1'];
    $ActividadPreponderableSegundaParte = $_POST['giro_preponderante_empresa2'];
    $ActividadComplementario = $_POST['giro_complementario_empresa1'];
    $ActividadComplementarioSegundaParte = $_POST['giro_complementario_empresa2'];
    $DescripcionEconomica = $_POST['desc_actividad_empresa'];
    $Inversion = $_POST['inversion_empresa'];
    $MontoInversion = $_POST['monto_inversion_empresa'];

    if (isset($_POST['tamanio_empresa1'])) {
        $tamanoEmpresa = $_POST['tamanio_empresa1'];
    } elseif (isset($_POST['tamanio_empresa2'])) {
        $tamanoEmpresa = $_POST['tamanio_empresa2'];
    } elseif (isset($_POST['tamanio_empresa3'])) {
        $tamanoEmpresa = $_POST['tamanio_empresa3'];
    } else {
        $tamanoEmpresa = $_POST['tamanio_empresa'];
    }
    $EmpleosExistentes = $_POST['empleos_existentes_empresa'];
    $EmpleosPorGenerar = $_POST['empleos_generar_empresa'];
    $HorarioTrabajoPrimerosDias = $_POST['lista_dias1_empresa'];
    $HorasInicioPrimerosDias = $_POST['hora_inicial_1_empresa'];
    $HorasFinalesPrimerosDias = $_POST['hora_fin_1_empresa'];
    $HorarioTrabajoSegundosDias = $_POST['lista_dias2_empresa'];
    $InicioHorarioTrabajoSegundosDias = $_POST['hora_inicial_2_empresa'];
    $FinalesHorasSegundosDias = $_POST['hora_fin_2_empresa'];
    $CupoDePersonas = $_POST['aforo'];


    if ($CatalogoMunicipal != "") {
        if ($GiroCatalogoMunicipal != "") {
            if ($DescripcionEmpresa != "") {
                if ($ActividadPreponderable != "") {
                    if ($ActividadPreponderableSegundaParte != "") {
                        if ($ActividadComplementario != "") {
                            if ($ActividadComplementarioSegundaParte != "") {
                                if ($DescripcionEconomica != "") {
                                    if ($Inversion != "") {
                                        if ($MontoInversion != "") {
                                            if ($tamanoEmpresa != "") {
                                                if ($EmpleosExistentes != "") {
                                                    if ($EmpleosPorGenerar != "") {
                                                        if ($HorarioTrabajoPrimerosDias != "") {
                                                            if ($HorasInicioPrimerosDias != "") {
                                                                if ($HorasFinalesPrimerosDias != "") {
                                                                    if ($HorarioTrabajoSegundosDias != "") {
                                                                        if ($InicioHorarioTrabajoSegundosDias != "") {
                                                                            if ($FinalesHorasSegundosDias != "") {
                                                                                if ($CupoDePersonas != "") {
                                                                                    $_SESSION["CatalogoMunicipal"] = $CatalogoMunicipal;
                                                                                    $_SESSION["GiroCatalogoMunicipal"] = $GiroCatalogoMunicipal;
                                                                                    $_SESSION["ActividadPreponderable"] = $ActividadPreponderable;
                                                                                    $_SESSION["ActividadPreponderableSegundaParte"] = $ActividadPreponderableSegundaParte;
                                                                                    $_SESSION["ActividadComplementario"] = $ActividadComplementario;
                                                                                    $_SESSION["ActividadComplementarioSegundaParte"] = $ActividadComplementarioSegundaParte;
                                                                                    $_SESSION["DescripcionEconomica"] = $DescripcionEconomica;
                                                                                    $_SESSION["Inversion"] = $Inversion;
                                                                                    $_SESSION["MontoInversion"] = $MontoInversion;
                                                                                    $_SESSION["tamanoEmpresa"] = $tamanoEmpresa;
                                                                                    $_SESSION["EmpleosExistentes"] = $EmpleosExistentes;
                                                                                    $_SESSION["EmpleosPorGenerar"] = $EmpleosPorGenerar;
                                                                                    $_SESSION["HorarioTrabajoPrimerosDias"] = $HorarioTrabajoPrimerosDias;
                                                                                    $_SESSION["HorasInicioPrimerosDias"] = $HorasInicioPrimerosDias;
                                                                                    $_SESSION["HorasFinalesPrimerosDias"] = $HorasFinalesPrimerosDias;
                                                                                    $_SESSION["HorarioTrabajoSegundosDias"] = $HorarioTrabajoSegundosDias;
                                                                                    $_SESSION["HorasInicioSegundosDias"] = $InicioHorarioTrabajoSegundosDias;
                                                                                    $_SESSION["HorasFinalesSegundosDias"] = $FinalesHorasSegundosDias;
                                                                                    $_SESSION["CupoDePersonas"] = $CupoDePersonas;

                                                                                    $queryUpdateTablaTramites = "UPDATE tramites SET FechaCreacionTramite ='$horaActual', StatusTramite = 'En Proceso',
                                            ActivoTramite = 1, NumeroTramites = 1, numeroPagina = 4  WHERE id_Tramite = $idTramite";
                                                                                    $result = mysqli_query($dbconexionBase, $queryUpdateTablaTramites);

                                                                                    if ($tipoTramite == "Moral"){
                                                                                        $id_TramiteMoral = $_SESSION["id_TramiteMoral"];
                                                                                        $queryUpdateTablaMoral = " UPDATE tabla_datospersonasmorales SET fechaRegistroMoral= '$horaActual', estatusPrimeraHoja= 'Completo',
                                                  estatusSegundaHoja='Completo',estatusTerceraHoja='Completo',estatusCuartaHoja='En Proceso', numeroPaginas = 4 WHERE  id_Tramite = $idTramite and id_TramiteMoral = $id_TramiteMoral";
                                                                                        $result = mysqli_query($dbconexionBase, $queryUpdateTablaMoral);
                                                                                        header("location: DatosPredio.php");
                                                                                    }
                                                                                    else{
                                                                                        $id_TramiteFisico = $_SESSION["id_TramiteFisico"];
                                                                                        $queryUpdateTablaFisica = " UPDATE tabla_datospersonasfisicas SET fechaRegistro= '$horaActual', estatusPrimeraHoja = 'Completo',
                                                  estatusSegundaHoja ='Completo',estatusTerceraHoja ='Completo',estatusCuartaHoja ='En Proceso', numeroPaginas = 4 WHERE  id_Tramite = $idTramite and id_TramitePersonaFisica = $id_TramiteFisico ";
                                                                                        $result = mysqli_query($dbconexionBase, $queryUpdateTablaFisica);
                                                                                        header("location: DatosPredio.php");
                                                                                    }
                                                                                } else {
                                                                                    header("location: DatosDeLaEmpresa.php?error=1&nom_variable=19");
                                                                                }
                                                                            } else {
                                                                                header("location: DatosDeLaEmpresa.php?error=1&nom_variable=18");
                                                                            }
                                                                        } else {
                                                                            header("location: DatosDeLaEmpresa.php?error=1&nom_variable=17");
                                                                        }
                                                                    } else {
                                                                        header("location: DatosDeLaEmpresa.php?error=1&nom_variable=16");
                                                                    }
                                                                } else {
                                                                    header("location: DatosDeLaEmpresa.php?error=1&nom_variable=15");
                                                                }
                                                            } else {
                                                                header("location: DatosDeLaEmpresa.php?error=1&nom_variable=14");
                                                            }
                                                        } else {
                                                            header("location: DatosDeLaEmpresa.php?error=1&nom_variable=13");
                                                        }
                                                    } else {
                                                        header("location: DatosDeLaEmpresa.php?error=1&nom_variable=12");
                                                    }
                                                } else {
                                                    header("location: DatosDeLaEmpresa.php?error=1&nom_variable=11");
                                                }
                                            } else {
                                                header("location: DatosDeLaEmpresa.php?error=1&nom_variable=10");
                                            }
                                        } else {
                                            header("location: DatosDeLaEmpresa.php?error=1&nom_variable=9");
                                        }
                                    } else {
                                        header("location: DatosDeLaEmpresa.php?error=1&nom_variable=8");
                                    }
                                } else {
                                    header("location: DatosDeLaEmpresa.php?error=1&nom_variable=7");
                                }
                            } else {
                                header("location: DatosDeLaEmpresa.php?error=1&nom_variable=6");
                            }
                        } else {
                            header("location: DatosDeLaEmpresa.php?error=1&nom_variable=5");
                        }
                    } else {
                        header("location: DatosDeLaEmpresa.php?error=1&nom_variable=4");
                    }
                } else {
                    header("location: DatosDeLaEmpresa.php?error=1&nom_variable=3");
                }
            } else {
                header("location: DatosDeLaEmpresa.php?error=1&nom_variable=2");
            }
        } else {
            header("location: DatosDeLaEmpresa.php?error=1&nom_variable=2");
        }
    } else {
        header("location: DatosDeLaEmpresa.php?error=1&nom_variable=1");
    }
}
?>

