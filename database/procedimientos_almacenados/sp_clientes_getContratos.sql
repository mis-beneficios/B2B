DROP PROCEDURE IF EXISTS sp_clientes_getContratos;
DELIMITER ;;
CREATE PROCEDURE sp_clientes_getContratos (IN p_id_usuario INT, OUT success INT,OUT message TEXT,OUT log TEXT)
BEGIN
    DECLARE p_id_padre INT DEFAULT 0;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN 
		GET DIAGNOSTICS CONDITION 1 @sqlstate=RETURNED_SQLSTATE,@errno=MYSQL_ERRNO, @text=MESSAGE_TEXT;
        SET success=-1;
		SET message='Lo sentimos, ha ocurrido un error al ejecutar sp_client_resumenSaldos';
		SET log=CONCAT(log," ERROR ", @errno, " (", @sqlstate, "): ", @text);
    END;

    SET success=0;
    
    DROP TEMPORARY TABLE IF EXISTS tmp_contratos_usuario;
    CREATE TEMPORARY TABLE tmp_contratos_usuario(
        id_folio INT UNSIGNED,
        sys_key VARCHAR(25) DEFAULT NULL,
        estatus VARCHAR(25) DEFAULT NULL,
        nombre_cliente VARCHAR(250) DEFAULT NULL,
        correo_cliente VARCHAR(100) DEFAULT NULL,
        nombre_paquete VARCHAR(100) DEFAULT NULL,
        precio_de_compra DECIMAL (15,2) DEFAULT 0,
        divisa VARCHAR (10) DEFAULT NULL,
        tipo_descuento VARCHAR (50) DEFAULT NULL,
        cantidad_pendiente DECIMAL (15,2) DEFAULT 0,
        saldo_pagado DECIMAL (15,2) DEFAULT 0,
        saldo_rechazado DECIMAL (15,2) DEFAULT 0,
        pagos_concretados INT DEFAULT 0,
        pagos_pendientes INT DEFAULT 0,
        pagos_rechazados INT DEFAULT 0,
        pagos_cancelados INT DEFAULT 0,
        pagos_total INT DEFAULT 0,
        correo_vendedor VARCHAR(100) DEFAULT NULL,
        padre_id VARCHAR(100) DEFAULT NULL,
        color_estatus VARCHAR(10) DEFAULT '#000',
        estatus_calidad TINYINT(1) DEFAULT 0,
        numero_reservaciones INT DEFAULT 0,
        fecha_primer_segmento DATE DEFAULT NULL,
        PRIMARY KEY (id_folio)
    );

    INSERT INTO tmp_contratos_usuario
    SELECT C.id,C.sys_key,C.estatus,
    CONCAT_WS(' ',U2.nombre,U2.apellidos),U2.username,
    C.paquete,C.precio_de_compra AS precio_de_compra, C.divisa,
    IF(C.via_serfin=1,'Descuento por serfin','') AS tipo_descuento,
    C.precio_de_compra - SUM(IF(P.estatus='Pagado',P.cantidad,0)) AS  cantidad_pendiente ,
    SUM(IF(P.estatus='Pagado',P.cantidad,0)) AS saldo_pagado,
    SUM(IF(P.estatus='Rechazado',P.cantidad,0)) AS saldo_rechazado,
    SUM(IF(P.estatus='Pagado',1,0)) AS pagos_concretados,
    SUM(IF(P.estatus='Por pagar',1,0)) AS pagos_pendientes,
    SUM(IF(P.estatus='Rechazado',1,0)) AS pagos_rechazados,
    SUM(IF(P.estatus='Cancelado',1,0)) AS pagos_cancelados,
    COUNT(P.estatus) AS pagos_total,
    IF(U.username IS NULL,'Sin vendedor',U.username) AS vendedor,C.padre_id,
    CASE 
        WHEN C.estatus ='suspendido' THEN '#5C5C5C'
        WHEN C.estatus ='sin_aprobar' THEN '#53007D'
        WHEN C.estatus ='por_autorizar' THEN '#F59B00'
        WHEN C.estatus ='nuevo' THEN '#165e6c'
        WHEN C.estatus ='por_cancelar' THEN '#dc3545'
        WHEN C.estatus ='cancelado' THEN '#8E0000'
        WHEN C.estatus ='Tarjeta con problemas' THEN '#fd7e14'
        WHEN C.estatus ='viajado' THEN '#000'
        ELSE '#007bff'
    END AS color_estatus,
    IF(I.id IS NOT NULL,1,0) AS estatus_calidad,COUNT(CR.id ),NULL
    FROM contratos C 
    JOIN pagos P ON C.id=P.contrato_id
    LEFT JOIN users U2 ON C.user_id=U2.id -- CLIENTE
    LEFT JOIN padres PP ON C.padre_id=PP.id
    LEFT JOIN users U ON PP.user_id=U.id -- USUARIO DE SISTEMA
    LEFT JOIN contratos_reservaciones CR ON C.id=CR.contrato_id
    LEFT JOIN imagenes I ON I.model_id=C.id
    WHERE C.user_id=p_id_usuario AND P.cantidad!=0 -- AND C.id=14149
    GROUP BY C.id;

    UPDATE tmp_contratos_usuario A
    LEFT JOIN pagos P ON P.contrato_id=A.id_folio
    SET A.fecha_primer_segmento=P.fecha_de_cobro 
    WHERE P.segmento=1;

    SELECT * FROM tmp_contratos_usuario;
    DROP TEMPORARY TABLE IF EXISTS tmp_contratos_usuario;

    SET success=1;
    SET message='sp_clientes_porUsuario ejecutado correctamente';

END;;
DELIMITER ;

-- CALL sp_clientes_getContratos(13014, @success,@message,@log);
-- SELECT @success,@message,@log;

-- https://admon.beneficiosvacacionales.mx/admin/users/13014