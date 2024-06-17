-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-06-2024 a las 04:29:54
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_tramite`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CARGAR_SEGUIMIENTO_TRAMITE` (IN `NUMERO` VARCHAR(12), IN `DNI` VARCHAR(12))   SELECT
	documento.documento_id, 
	documento.doc_dniremitente, 
	CONCAT_WS(' ',documento.doc_nombreremitente,documento.doc_apepatremitente,documento.doc_apematremitente),
	documento.doc_fecharegistro
FROM
	documento
	WHERE documento.documento_id=NUMERO and documento.doc_dniremitente=DNI$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CARGAR_SEGUIMIENTO_TRAMITE_DETALLE` (IN `NUMERO` VARCHAR(12))   SELECT
	movimiento.movimiento_id, 
	movimiento.documento_id, 
	area.area_nombre, 
	movimiento.mov_fecharegistro, 
	movimiento.mov_descripcion, 
	movimiento.mov_estatus
FROM
	movimiento
	INNER JOIN
	area
	ON 
		movimiento.areadestino_id = area.area_cod
		where movimiento.documento_id=NUMERO$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CARGAR_SELECT_AREA` ()   SELECT
	area.area_cod, 
	area.area_nombre
FROM
	area$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CARGAR_SELECT_EMPLEADO` ()   SELECT
	empleado.empleado_id, 
	CONCAT_WS(' ',empleado.emple_nombre,empleado.emple_apepat,empleado.emple_apemat)
FROM
	empleado$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CARGAR_SELECT_TIPO` ()   SELECT
	tipo_documento.tipodocumento_id, 
	tipo_documento.tipodo_descripcion
FROM
	tipo_documento
	where tipo_documento.tipodo_estado='ACTIVO'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_AREA` ()   SELECT
	area.area_cod, 
	area.area_nombre, 
	area.area_fecha_registro, 
	area.area_estado
FROM
	area$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_EMPLEADO` ()   SELECT
	empleado.empleado_id, 
	empleado.emple_nombre, 
	empleado.emple_apepat, 
	empleado.emple_apemat, 
	empleado.emple_fechanacimiento, 
	empleado.emple_nrodocumento, 
	empleado.emple_movil, 
	empleado.emple_email, 
	empleado.emple_estatus, 
	empleado.emple_direccion, 
	empleado.empl_fotoperfil,
	CONCAT_WS(' ',	empleado.emple_nombre,empleado.emple_apemat,empleado.emple_apemat) as em
FROM
	empleado$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_TIPO_DOCUMENTO` ()   SELECT
	tipo_documento.tipodocumento_id, 
	tipo_documento.tipodo_descripcion, 
	tipo_documento.tipodo_estado,
	tipo_documento.tipodo_fregistro
FROM
	tipo_documento$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_TRAMITE` ()   SELECT
	documento.documento_id, 
	documento.doc_dniremitente, 
	CONCAT_WS(' ',documento.doc_nombreremitente,documento.doc_apepatremitente,documento.doc_apematremitente) AS REMITENTE, 
	documento.tipodocumento_id, 
	tipo_documento.tipodo_descripcion, 
	documento.doc_estatus, 
	origen.area_nombre AS origen, 
	destino.area_nombre AS destino, 
	documento.doc_nrodocumento, 
	documento.doc_nombreremitente, 
	documento.doc_apepatremitente, 
	documento.doc_apematremitente, 
	documento.doc_celularremitente, 
	documento.doc_emailremitente, 
	documento.doc_direccionremitente, 
	documento.doc_representacion, 
	documento.doc_ruc, 
	documento.doc_empresa, 
	documento.doc_folio, 
	documento.doc_asunto, 
	documento.doc_fecharegistro, 
	documento.area_origen, 
	documento.area_destino
FROM
	documento
	INNER JOIN
	tipo_documento
	ON 
		documento.tipodocumento_id = tipo_documento.tipodocumento_id
	INNER JOIN
	area AS origen
	ON 
		documento.area_origen = origen.area_cod
	INNER JOIN
	area AS destino
	ON 
		documento.area_destino = destino.area_cod$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_TRAMITE_AREA` (IN `IDUSUARIO` INT)   BEGIN
DECLARE IDAREA INT;
SET @IDAREA:=(select area_id from usuario where usu_id=IDUSUARIO);
SELECT
	documento.documento_id, 
	documento.doc_dniremitente, 
	CONCAT_WS(' ',documento.doc_nombreremitente,documento.doc_apepatremitente,documento.doc_apematremitente) AS REMITENTE, 
	documento.tipodocumento_id, 
	tipo_documento.tipodo_descripcion, 
	documento.doc_estatus, 
	origen.area_nombre AS origen, 
	destino.area_nombre AS destino, 
	documento.doc_nrodocumento, 
	documento.doc_nombreremitente, 
	documento.doc_apepatremitente, 
	documento.doc_apematremitente, 
	documento.doc_celularremitente, 
	documento.doc_emailremitente, 
	documento.doc_direccionremitente, 
	documento.doc_representacion, 
	documento.doc_ruc, 
	documento.doc_empresa, 
	documento.doc_folio, 
	documento.doc_asunto, 
	documento.doc_fecharegistro, 
	documento.area_origen, 
	documento.area_destino
FROM
	documento
	INNER JOIN
	tipo_documento
	ON 
		documento.tipodocumento_id = tipo_documento.tipodocumento_id
	INNER JOIN
	area AS origen
	ON 
		documento.area_origen = origen.area_cod
	INNER JOIN
	area AS destino
	ON 
		documento.area_destino = destino.area_cod
	where 	documento.area_destino=@IDAREA;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_TRAMITE_SEGUIMIENTO` (IN `ID` CHAR(11))   SELECT
	movimiento.movimiento_id, 
	movimiento.documento_id, 
	movimiento.area_origen_id, 
	area.area_nombre, 
	movimiento.mov_fecharegistro, 
	movimiento.mov_descripcion, 
	movimiento.mov_archivo
FROM
	movimiento
	INNER JOIN
	area
	ON 
		movimiento.area_origen_id = area.area_cod
		where 	movimiento.documento_id=ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_USUARIO` ()   SELECT
	usuario.usu_id, 
	usuario.usu_usuario, 
	usuario.empleado_id, 
	usuario.usu_observacion, 
	usuario.usu_estatus, 
	usuario.area_id, 
	usuario.usu_rol, 
	usuario.empresa_id, 
	area.area_nombre, 
	CONCAT_WS(' ',empleado.emple_nombre,empleado.emple_apepat,empleado.emple_apemat) as nempleaddo
FROM
	usuario
	INNER JOIN
	area
	ON 
		usuario.area_id = area.area_cod
	INNER JOIN
	empleado
	ON 
		usuario.empleado_id = empleado.empleado_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_AREA` (IN `ID` INT, IN `NAREA` VARCHAR(255), IN `ESTATUS` VARCHAR(20))   BEGIN
DECLARE AREAACTUAL VARCHAR(255);
DECLARE CANTIDAD INT;
SET @AREAACTUAL:=(SELECT area_nombre from area where area_cod=ID);
IF @AREAACTUAL = NAREA THEN
		UPDATE area set
		area_estado=ESTATUS,
		area_nombre=NAREA
		where area_cod=ID;
		SELECT 1;
ELSE
SET @CANTIDAD:=(SELECT COUNT(*) from area where area_nombre=NAREA);
	IF @CANTIDAD = 0 THEN
		UPDATE area set
		area_estado=ESTATUS,
		area_nombre=NAREA
		where area_cod=ID;
		SELECT 1;
	ELSE
		SELECT 2;
	
	END IF;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_EMPLEADO` (IN `ID` INT, IN `NDOCUMENTO` CHAR(12), IN `NOMBRE` VARCHAR(150), IN `APEPAT` VARCHAR(100), IN `APEMAT` VARCHAR(100), IN `FECHA` DATE, IN `MOVIL` CHAR(9), IN `DIRECCION` VARCHAR(255), IN `EMAIL` VARCHAR(255), IN `ESTATUS` VARCHAR(20))   BEGIN
DECLARE NDOCUMENTOACTUAL CHAR(12);
DECLARE CANTIDAD INT;
SET @NDOCUMENTOACTUAL:=(SELECT emple_nrodocumento from empleado where empleado_id=ID);
IF @NDOCUMENTOACTUAL = NDOCUMENTO THEN
	UPDATE empleado SET
	emple_nrodocumento=NDOCUMENTO,
	emple_nombre=NOMBRE,
	emple_apepat=APEPAT,
	emple_apemat=APEMAT,
  emple_fechanacimiento=FECHA,
	emple_movil=MOVIL,
	emple_direccion=DIRECCION,
	emple_email=EMAIL,
	emple_estatus=ESTATUS
	WHERE empleado_id=ID;
	SELECT 1;
ELSE
	SET @CANTIDAD:=(SELECT COUNT(*) FROM empleado where emple_nrodocumento=NDOCUMENTO);
	IF @CANTIDAD = 0 THEN
		UPDATE empleado SET
		emple_nrodocumento=NDOCUMENTO,
		emple_nombre=NOMBRE,
		emple_apepat=APEPAT,
		emple_apemat=APEMAT,
		emple_fechanacimiento=FECHA,
		emple_movil=MOVIL,
		emple_direccion=DIRECCION,
		emple_email=EMAIL,
		emple_estatus=ESTATUS
		WHERE empleado_id=ID;
		SELECT 1;
	ELSE
	SELECT 2;
	END IF;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_TIPO` (IN `ID` INT, IN `NTIPO` VARCHAR(255), IN `ESTATUS` VARCHAR(20))   BEGIN
DECLARE TIPOACTUAL VARCHAR(255);
DECLARE CANTIDAD INT;
SET @TIPOACTUAL:=(SELECT tipodo_descripcion  FROM tipo_documento where tipodocumento_id=ID);
IF @TIPOACTUAL = NTIPO THEN
  UPDATE tipo_documento set
	tipodo_descripcion=NTIPO,
	tipodo_estado=ESTATUS
	where tipodocumento_id=ID;
	SELECT 1;
ELSE
	SET @CANTIDAD:=(SELECT COUNT(*) FROM tipo_documento where tipodo_descripcion=NTIPO);
	IF @CANTIDAD = 0 THEN
		UPDATE tipo_documento set
		tipodo_descripcion=NTIPO,
		tipodo_estado=ESTATUS
		where tipodocumento_id=ID;
		SELECT 1;
		SELECT 1;
	ELSE
		SELECT 2;
END IF;

END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_USUARIO` (IN `ID` INT, IN `IDEMPLEADO` INT, IN `IDAREA` INT, IN `ROL` VARCHAR(25))   UPDATE usuario set
empleado_id=IDEMPLEADO,
area_id=IDAREA,
usu_rol=ROL
where usu_id=ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_USUARIO_CONTRA` (IN `ID` INT, IN `CONTRA` VARCHAR(250))   UPDATE usuario set
usu_contra=CONTRA
where usu_id=ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_USUARIO_ESTATUS` (IN `ID` INT, IN `ESTATUS` VARCHAR(20))   UPDATE usuario set
usu_estatus=ESTATUS
where usu_id=ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_AREA` (IN `NAREA` VARCHAR(255))   BEGIN
DECLARE CANTIDAD INT;
SET @CANTIDAD:=(SELECT COUNT(*) FROM area where area_nombre=NAREA);
IF @CANTIDAD = 0 THEN
	INSERT INTO area(area_nombre,area_fecha_registro)VALUES(NAREA,NOW());
	SELECT 1;
ELSE
	SELECT 2;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_EMPLEADO` (IN `NDOCUMENTO` CHAR(12), IN `NOMBRE` VARCHAR(150), IN `APEPAT` VARCHAR(100), IN `APEMAT` VARCHAR(100), IN `FECHA` DATE, IN `MOVIL` CHAR(9), IN `DIRECCION` VARCHAR(255), IN `EMAIL` VARCHAR(255))   BEGIN
DECLARE CANTIDAD INT;
SET @CANTIDAD:=(SELECT COUNT(*) FROM empleado where emple_nrodocumento=NDOCUMENTO);
IF @CANTIDAD = 0 THEN
	INSERT INTO empleado(emple_nrodocumento,emple_nombre,emple_apepat,emple_apemat,emple_fechanacimiento,emple_movil,emple_direccion,emple_email,emple_feccreacion,emple_estatus,empl_fotoperfil) VALUES(NDOCUMENTO,NOMBRE,APEPAT,APEMAT,FECHA,MOVIL,DIRECCION,EMAIL,CURDATE(),'ACTIVO','controller/empleado/FOTOS/admin.png');
	SELECT 1;
ELSE
SELECT 2;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_TIPO` (IN `NTIPO` VARCHAR(255))   BEGIN
DECLARE CANTIDAD INT;
SET @CANTIDAD:=(SELECT COUNT(*) FROM tipo_documento where tipodo_descripcion=NTIPO);
IF @CANTIDAD = 0 THEN
	INSERT INTO tipo_documento(tipodo_descripcion,tipodo_estado,tipodo_fregistro) VALUES(NTIPO,'ACTIVO',NOW());
	SELECT 1;
ELSE
	SELECT 2;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_TRAMITE` (IN `DNI` CHAR(8), IN `NOMBRE` VARCHAR(150), IN `APEPAT` VARCHAR(50), IN `APEMAT` VARCHAR(50), IN `CEL` CHAR(9), IN `EMAIL` VARCHAR(150), IN `DIRECCION` VARCHAR(255), IN `REPRESENTACION` VARCHAR(50), IN `RUC` CHAR(12), IN `RAZON` VARCHAR(255), IN `AREAPRINCIPAL` INT, IN `AREADESTINO` INT, IN `TIPO` INT, IN `NRODOCUMENTO` VARCHAR(15), IN `ASUNTO` VARCHAR(255), IN `RUTA` VARCHAR(255), IN `FOLIO` INT, IN `IDUSUARIO` INT)   BEGIN
DECLARE cantidad INT;
declare cod char(12);
SET @cantidad :=(SELECT count(*) FROM documento );
IF @cantidad >= 1 AND @cantidad <= 8  THEN
SET @cod :=(SELECT CONCAT('D000000',(@cantidad+1)));
ELSEIF @cantidad >=9 AND @cantidad <=98 THEN
SET @cod :=(SELECT CONCAT('D00000',(@cantidad+1)));
ELSEIF @cantidad >=99 AND @cantidad <=998 THEN
SET @cod :=(SELECT CONCAT('D0000',(@cantidad+1)));
ELSEIF @cantidad >=999 AND @cantidad <=9998 THEN
SET @cod :=(SELECT CONCAT('D000',(@cantidad+1)));
ELSEIF @cantidad >=9999 AND @cantidad <=99998 THEN
SET @cod :=(SELECT CONCAT('D00',(@cantidad+1)));
ELSEIF @cantidad >=99999 AND @cantidad <=999998 THEN
SET @cod :=(SELECT CONCAT('D0',(@cantidad+1)));
ELSEIF @cantidad >=999999 THEN
SET @cod :=(SELECT CONCAT('D',(@cantidad+1)));
ELSE
SET @cod :=(SELECT CONCAT('D0000001'));
END IF;
INSERT INTO documento(documento_id,doc_dniremitente,doc_nombreremitente,doc_apepatremitente,doc_apematremitente,doc_celularremitente,doc_emailremitente,doc_direccionremitente,doc_representacion,doc_ruc,doc_empresa,area_origen,area_destino,tipodocumento_id,doc_nrodocumento,doc_asunto,doc_archivo,doc_folio) VALUES(@cod,DNI,NOMBRE,APEPAT,APEMAT,CEL,EMAIL,DIRECCION,REPRESENTACION,RUC,RAZON,AREAPRINCIPAL,AREADESTINO,TIPO,NRODOCUMENTO,ASUNTO,RUTA,FOLIO);
SELECT @cod;
INSERT INTO movimiento(documento_id,area_origen_id,areadestino_id,mov_fecharegistro,mov_descripcion,mov_estatus,usuario_id,mov_archivo) VALUES(@cod,AREAPRINCIPAL,AREADESTINO,NOW(),ASUNTO,'PENDIENTE',IDUSUARIO,RUTA);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_TRAMITE_DERIVAR` (IN `ID` CHAR(15), IN `ORIGEN` INT, IN `DESTINO` INT, IN `DESCRIPCION` VARCHAR(255), IN `IDUSUARIO` INT, IN `RUTA` VARCHAR(255), IN `TIPO` VARCHAR(255))   BEGIN
DECLARE IDMOVIMENTO INT;
SET @IDMOVIMENTO:=(select movimiento_id from movimiento where mov_estatus='PENDIENTE' AND documento_id=ID);
IF TIPO = "FINALIZAR" THEN

UPDATE movimiento SET
mov_estatus='FINALIZADO'
where movimiento_id=@IDMOVIMENTO;
UPDATE documento SET
area_origen=ORIGEN,
area_destino=ORIGEN,
doc_estatus='FINALIZADO'
WHERE documento_id=ID;
INSERT INTO movimiento(documento_id,area_origen_id,areadestino_id,mov_fecharegistro,mov_descripcion,mov_estatus,usuario_id,mov_archivo) VALUES(ID,ORIGEN,ORIGEN,NOW(),DESCRIPCION,'FINALIZADO',IDUSUARIO,RUTA);

ELSE

UPDATE movimiento SET
mov_estatus='DERIVADO'
where movimiento_id=@IDMOVIMENTO;
UPDATE documento SET
area_origen=ORIGEN,
area_destino=DESTINO
WHERE documento_id=ID;
INSERT INTO movimiento(documento_id,area_origen_id,areadestino_id,mov_fecharegistro,mov_descripcion,mov_estatus,usuario_id,mov_archivo) VALUES(ID,ORIGEN,DESTINO,NOW(),DESCRIPCION,'PENDIENTE',IDUSUARIO,RUTA);

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_USUARIO` (IN `USU` VARCHAR(250), IN `CONTRA` VARCHAR(255), IN `IDEMPLEADO` INT, IN `IDAREA` INT, IN `ROL` VARCHAR(25))   BEGIN
DECLARE CANTIDAD INT;
SET @CANTIDAD:=(SELECT COUNT(*) FROM usuario where usu_usuario=USU);
IF @CANTIDAD = 0 THEN
	
	INSERT INTO usuario(usu_usuario,usu_contra,empleado_id,area_id,usu_rol,usu_feccreacion,usu_estatus,empresa_id) VALUES(USU,CONTRA,IDEMPLEADO,IDAREA,ROL,CURDATE(),'ACTIVO',1);
	SELECT 1;

ELSE

SELECT 2;
END IF;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_TRAER_WIDGET` ()   SELECT
	(select COUNT(*) FROM documento),
	(select COUNT(*) FROM documento where doc_estatus="FINALIZADO")
FROM
	documento LIMIT 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_VERIFICAR_USUARIO` (IN `USU` VARCHAR(255))   SELECT
	usuario.usu_id, 
	usuario.usu_usuario, 
	usuario.usu_contra, 
	usuario.usu_feccreacion, 
	usuario.usu_fecupdate, 
	usuario.empleado_id, 
	usuario.usu_observacion, 
	usuario.usu_estatus, 
	usuario.area_id, 
	usuario.usu_rol, 
	usuario.empresa_id
FROM
	usuario
	where usuario.usu_usuario  = BINARY USU$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `area_cod` int(11) NOT NULL COMMENT 'Codigo auto-incrementado del movimiento del area',
  `area_nombre` varchar(50) NOT NULL COMMENT 'nombre del area',
  `area_fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'fecha del registro del movimiento',
  `area_estado` enum('ACTIVO','INACTIVO') NOT NULL DEFAULT 'ACTIVO' COMMENT 'estado del area'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Entidad Area' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`area_cod`, `area_nombre`, `area_fecha_registro`, `area_estado`) VALUES
(1, 'MESA DE PARTES', '2021-09-24 06:26:04', 'ACTIVO'),
(2, 'RECURSOS HUMANOS', '2021-10-02 03:35:56', 'ACTIVO'),
(3, 'CONTABILIDAD', '2021-10-02 03:36:52', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `documento_id` char(12) NOT NULL,
  `doc_dniremitente` char(8) NOT NULL,
  `doc_nombreremitente` varchar(150) NOT NULL,
  `doc_apepatremitente` varchar(50) NOT NULL,
  `doc_apematremitente` varchar(50) NOT NULL,
  `doc_celularremitente` char(9) NOT NULL,
  `doc_emailremitente` varchar(150) NOT NULL,
  `doc_direccionremitente` varchar(255) NOT NULL,
  `doc_representacion` varchar(50) NOT NULL,
  `doc_ruc` char(12) NOT NULL,
  `doc_empresa` varchar(255) NOT NULL,
  `tipodocumento_id` int(11) NOT NULL,
  `doc_nrodocumento` varchar(15) NOT NULL DEFAULT '',
  `doc_folio` int(11) NOT NULL,
  `doc_asunto` varchar(255) NOT NULL,
  `doc_archivo` varchar(255) NOT NULL,
  `doc_fecharegistro` datetime DEFAULT current_timestamp(),
  `area_id` int(11) DEFAULT 1,
  `doc_estatus` enum('PENDIENTE','RECHAZADO','FINALIZADO') NOT NULL,
  `area_origen` int(11) NOT NULL DEFAULT 0,
  `area_destino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `documento`
--

INSERT INTO `documento` (`documento_id`, `doc_dniremitente`, `doc_nombreremitente`, `doc_apepatremitente`, `doc_apematremitente`, `doc_celularremitente`, `doc_emailremitente`, `doc_direccionremitente`, `doc_representacion`, `doc_ruc`, `doc_empresa`, `tipodocumento_id`, `doc_nrodocumento`, `doc_folio`, `doc_asunto`, `doc_archivo`, `doc_fecharegistro`, `area_id`, `doc_estatus`, `area_origen`, `area_destino`) VALUES
('D0000001', '76216924', 'LOGUY ENRIQUE', 'TORRES', 'TORRES', '1231', 'LERT.07.04.95@GMAIL.COM', 'JR ICA 820', 'A NOMBRE PROPIO', '', '', 2, '124', 213, '4124', 'controller/tramite/documentos/ARCH8620221646.PNG', '2022-06-08 01:19:28', 1, 'FINALIZADO', 1, 1),
('D0000002', '213', '12313', '12321', '213', '12312', '123', '123', 'A NOMBRE PROPIO', '', '', 3, '1231', 123, 'ASDAS', 'controller/tramite/documentos/ARCH106202222667.PDF', '2022-06-10 22:03:47', 1, 'FINALIZADO', 2, 2),
('D0000003', '29941366', 'JESUS', 'ZIEGLER', 'MOTA', '041224465', 'JMZM08@GMAIL.COM', 'LAS PALMAS', 'A NOMBRE PROPIO', '', '', 2, '0222223', 73737733, 'PRUEBA DE TRAMITE', 'controller/tramite/documentos/ARCH6520240486.PDF', '2024-05-06 00:17:31', 1, 'FINALIZADO', 2, 2),
('D0000004', '34234234', 'JESUS', 'MANSAS', 'SADASD', '041234545', 'JMZXNMZ@GMAIL.COM', '1231241241DSSADASD', 'A NOMBRE PROPIO', '', '', 1, '34533453', 12312313, 'ADADAWD ', 'controller/tramite/documentos/ARCH21520248341.DOCX', '2024-05-21 08:35:19', 1, 'FINALIZADO', 1, 1),
('D0000005', '123456', 'JESUS', 'MANSAS', 'SEBALLOS', '041224465', 'JMZXNMZ@GMAIL.COM', 'PRUEBA DE DIRECCION', 'A OTRA PERSONA NATURAL', '', '', 3, '12345678', 9, 'PRUEBA DE SEGUIMIENTO', 'controller/tramite/documentos/ARCH36202421879.PDF', '2024-06-03 21:45:33', 1, 'FINALIZADO', 1, 1),
('D0000006', '8788183', 'BEHETTY', 'CORONADO', 'MOTA', '041224465', 'PRUEBA@GMAIL.COM', 'LAS PALMAS, CARRETERA NACIONAL VIA SAN SEBASTIAN DE LOS REYES', 'A NOMBRE PROPIO', '', '', 3, '143', 10, 'PRUEBA REAL DE TRAMITE', 'controller/tramite/documentos/ARCH36202422688.PDF', '2024-06-03 22:24:30', 1, 'FINALIZADO', 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `empleado_id` int(11) NOT NULL,
  `emple_nombre` varchar(150) DEFAULT NULL,
  `emple_apepat` varchar(100) DEFAULT NULL,
  `emple_apemat` varchar(100) DEFAULT NULL,
  `emple_feccreacion` date DEFAULT NULL,
  `emple_fechanacimiento` date DEFAULT NULL,
  `emple_nrodocumento` char(12) DEFAULT NULL,
  `emple_movil` char(15) DEFAULT NULL,
  `emple_email` varchar(250) DEFAULT NULL,
  `emple_estatus` enum('ACTIVO','INACTIVO') NOT NULL,
  `emple_direccion` varchar(255) DEFAULT NULL,
  `emple_telefono` char(15) DEFAULT NULL,
  `empl_fotoperfil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`empleado_id`, `emple_nombre`, `emple_apepat`, `emple_apemat`, `emple_feccreacion`, `emple_fechanacimiento`, `emple_nrodocumento`, `emple_movil`, `emple_email`, `emple_estatus`, `emple_direccion`, `emple_telefono`, `empl_fotoperfil`) VALUES
(1, 'JESUS MIGUEL', 'ZIEGLER', 'MOTA', '2024-02-01', '2003-04-08', '29941366', '04122446504', 'JMZM08@gmail.com', 'ACTIVO', 'PALMAS', NULL, NULL),
(20, 'ASDSADASDA', 'XCXZC', 'ASDAS', '2021-10-12', '1995-04-07', '14124214', '24124124', 'ASDSADAS@GMAIL.COM', 'ACTIVO', 'ASDASASDASD', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `empresa_id` int(11) NOT NULL,
  `emp_razon` varchar(250) NOT NULL,
  `emp_email` varchar(250) NOT NULL,
  `emp_cod` varchar(10) NOT NULL,
  `emp_telefono` varchar(20) NOT NULL,
  `emp_direccion` varchar(250) NOT NULL,
  `emp_logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`empresa_id`, `emp_razon`, `emp_email`, `emp_cod`, `emp_telefono`, `emp_direccion`, `emp_logo`) VALUES
(1, 'ALCALDIA', 'ALCALDIA@GMAIL.CCOM', '', '3437645', '', 'logo.JPG');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento`
--

CREATE TABLE `movimiento` (
  `movimiento_id` int(11) NOT NULL,
  `documento_id` char(12) NOT NULL,
  `area_origen_id` int(11) DEFAULT NULL,
  `areadestino_id` int(11) NOT NULL,
  `mov_fecharegistro` datetime DEFAULT current_timestamp(),
  `mov_descripcion` varchar(255) NOT NULL,
  `mov_estatus` enum('PENDIENTE','CONFORME','INCOFORME','ACEPTADO','DERIVADO','FINALIZADO','RECHAZADO') DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `mov_archivo` varchar(255) DEFAULT NULL,
  `mov_descripcion_original` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `movimiento`
--

INSERT INTO `movimiento` (`movimiento_id`, `documento_id`, `area_origen_id`, `areadestino_id`, `mov_fecharegistro`, `mov_descripcion`, `mov_estatus`, `usuario_id`, `mov_archivo`, `mov_descripcion_original`) VALUES
(1, 'D0000001', 1, 1, '2022-06-08 01:19:28', '4124', 'FINALIZADO', 33, 'controller/tramite/documentos/ARCH8620221646.PNG', NULL),
(2, 'D0000001', 1, 1, '2022-06-08 01:20:01', '', 'FINALIZADO', 34, 'controller/tramite_area/documentos/ARCH8620221295.XLSX', NULL),
(3, 'D0000002', 1, 2, '2022-06-10 22:03:47', 'ASDAS', 'FINALIZADO', 34, 'controller/tramite/documentos/ARCH106202222667.PDF', NULL),
(4, 'D0000002', 2, 2, '2022-06-10 22:04:19', 'ASDA', 'FINALIZADO', 35, '', NULL),
(5, 'D0000003', 2, 2, '2024-05-06 00:17:31', 'PRUEBA DE TRAMITE', 'FINALIZADO', 36, 'controller/tramite/documentos/ARCH6520240486.PDF', NULL),
(6, 'D0000003', 2, 2, '2024-05-21 08:28:05', '', 'FINALIZADO', 35, '', NULL),
(7, 'D0000004', 3, 3, '2024-05-21 08:35:19', 'ADADAWD ', 'DERIVADO', 36, 'controller/tramite/documentos/ARCH21520248341.DOCX', NULL),
(8, 'D0000004', 3, 1, '2024-06-03 20:09:19', 'UNA PRUEBA CORTA', 'FINALIZADO', 35, 'controller/tramite_area/documentos/ARCH36202420444.PDF', NULL),
(9, 'D0000004', 1, 1, '2024-06-03 20:11:02', '', 'FINALIZADO', 35, '', NULL),
(10, 'D0000005', 3, 1, '2024-06-03 21:45:33', 'PRUEBA DE SEGUIMIENTO', 'FINALIZADO', 36, 'controller/tramite/documentos/ARCH36202421879.PDF', NULL),
(11, 'D0000005', 1, 1, '2024-06-03 21:46:28', '', 'FINALIZADO', 35, '', NULL),
(13, 'D0000006', 1, 3, '2024-06-03 22:25:54', 'PRUEBA DE DERIVACION', 'FINALIZADO', 35, 'controller/tramite_area/documentos/ARCH36202422915.PDF', NULL),
(14, 'D0000006', 3, 3, '2024-06-03 22:27:34', 'FINALIZADO CON EXITO', 'FINALIZADO', 35, '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `tipodocumento_id` int(11) NOT NULL COMMENT 'Codigo auto-incrementado del tipo documento',
  `tipodo_descripcion` varchar(50) NOT NULL COMMENT 'Descripcion del  tipo documento',
  `tipodo_estado` enum('ACTIVO','INACTIVO') NOT NULL COMMENT 'estado del tipo de documento',
  `tipodo_fregistro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Entidad Documento' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`tipodocumento_id`, `tipodo_descripcion`, `tipodo_estado`, `tipodo_fregistro`) VALUES
(1, 'asdasd', 'ACTIVO', '2021-10-05 02:08:08'),
(2, 'CARTA', 'ACTIVO', '2021-10-08 00:49:46'),
(3, 'PAPELEO', 'ACTIVO', '2021-10-08 00:50:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usu_id` int(11) NOT NULL,
  `usu_usuario` varchar(250) DEFAULT '',
  `usu_contra` varchar(250) DEFAULT NULL,
  `usu_feccreacion` date DEFAULT NULL,
  `usu_fecupdate` date DEFAULT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `usu_observacion` varchar(250) DEFAULT NULL,
  `usu_estatus` enum('ACTIVO','INACTIVO') NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `usu_rol` enum('Secretario (a)','Administrador') NOT NULL,
  `empresa_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usu_id`, `usu_usuario`, `usu_contra`, `usu_feccreacion`, `usu_fecupdate`, `empleado_id`, `usu_observacion`, `usu_estatus`, `area_id`, `usu_rol`, `empresa_id`) VALUES
(33, 'luiyi', '$2y$12$kkd8mirw3.lcKhjgxuQpVutuD/IH8gS.zwxQ3ZGHiu4sw1BlxmkWW', '2021-09-24', NULL, 20, NULL, 'ACTIVO', 2, 'Administrador', 1),
(34, 'PRUEBA', '$2y$12$kkd8mirw3.lcKhjgxuQpVutuD/IH8gS.zwxQ3ZGHiu4sw1BlxmkWW', '2021-10-19', NULL, 1, NULL, 'INACTIVO', 3, 'Administrador', 1),
(35, 'PRUEBA', '$2y$12$8AAbGbNcCrHbDyculyuqIuWMxGuFNjfBPFBTBg0ixLADDfgDbOsBe', '2022-04-29', NULL, 20, NULL, 'ACTIVO', 3, 'Secretario (a)', 1),
(36, 'JESUS', '$2y$12$twABsIl2TWCfpHoIDV8sRedxjqY5ll6hksyze/I3QBFnzxRiu99qy', '2024-02-05', NULL, 1, NULL, 'ACTIVO', 3, 'Administrador', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`area_cod`) USING BTREE,
  ADD UNIQUE KEY `unico` (`area_nombre`) USING BTREE;

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`documento_id`) USING BTREE,
  ADD KEY `tipodocumento_id` (`tipodocumento_id`) USING BTREE,
  ADD KEY `area_id` (`area_id`) USING BTREE,
  ADD KEY `area_origen` (`area_origen`) USING BTREE,
  ADD KEY `area_destino` (`area_destino`) USING BTREE;

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`empleado_id`) USING BTREE;

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`empresa_id`) USING BTREE;

--
-- Indices de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD PRIMARY KEY (`movimiento_id`) USING BTREE,
  ADD KEY `area_origen_id` (`area_origen_id`) USING BTREE,
  ADD KEY `areadestino_id` (`areadestino_id`) USING BTREE,
  ADD KEY `usuario_id` (`usuario_id`) USING BTREE,
  ADD KEY `documento_id` (`documento_id`) USING BTREE;

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`tipodocumento_id`) USING BTREE;

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usu_id`) USING BTREE,
  ADD KEY `empleado_id` (`empleado_id`) USING BTREE,
  ADD KEY `area_id` (`area_id`) USING BTREE,
  ADD KEY `empresa_id` (`empresa_id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `area_cod` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Codigo auto-incrementado del movimiento del area', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `empleado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `empresa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `movimiento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `tipodocumento_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Codigo auto-incrementado del tipo documento', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`tipodocumento_id`) REFERENCES `tipo_documento` (`tipodocumento_id`),
  ADD CONSTRAINT `documento_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_cod`),
  ADD CONSTRAINT `documento_ibfk_3` FOREIGN KEY (`area_origen`) REFERENCES `area` (`area_cod`),
  ADD CONSTRAINT `documento_ibfk_4` FOREIGN KEY (`area_destino`) REFERENCES `area` (`area_cod`);

--
-- Filtros para la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD CONSTRAINT `movimiento_ibfk_1` FOREIGN KEY (`area_origen_id`) REFERENCES `area` (`area_cod`),
  ADD CONSTRAINT `movimiento_ibfk_2` FOREIGN KEY (`areadestino_id`) REFERENCES `area` (`area_cod`),
  ADD CONSTRAINT `movimiento_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usu_id`),
  ADD CONSTRAINT `movimiento_ibfk_4` FOREIGN KEY (`documento_id`) REFERENCES `documento` (`documento_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleado` (`empleado_id`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_cod`),
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`empresa_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
