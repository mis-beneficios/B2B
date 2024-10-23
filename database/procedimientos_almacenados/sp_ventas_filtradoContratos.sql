DROP PROCEDURE IF EXISTS sp_ventas_filtradoContratos;
DELIMITER ;;
CREATE PROCEDURE sp_ventas_filtradoContratos ( IN p_json MEDIUMTEXT,IN p_id_usuario INT, OUT success INT,OUT message TEXT,OUT log TEXT)
BEGIN
    DECLARE p_id_padre INT DEFAULT 0;
    DECLARE p_fecha_inicial DATE DEFAULT CURRENT_DATE;
    DECLARE p_fecha_final DATE DEFAULT CURRENT_DATE;
 
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN 
		GET DIAGNOSTICS CONDITION 1 @sqlstate=RETURNED_SQLSTATE,@errno=MYSQL_ERRNO, @text=MESSAGE_TEXT;
        SET success=-1;
		SET message='Lo sentimos, ha ocurrido un error al ejecutar sp_ventas_filtradoContratos';
		SET log=CONCAT(log," ERROR ", @errno, " (", @sqlstate, "): ", @text);
    END;

    SET success=0;
    
    SET p_fecha_inicial=JSON_UNQUOTE(JSON_EXTRACT(p_json, '$.fecha_inicio'));
    SET p_fecha_final=JSON_UNQUOTE(JSON_EXTRACT(p_json, '$.fecha_fin'));

    SELECT C.id,C.user_id,CONCAT_WS(' ',U2.nombre,U2.apellidos) AS cliente,
        C.paquete,C.estatus,C.created,
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
        COUNT(P.estatus) AS cuotas_pagos,
        C.pagos,
        SUM(IF(P.estatus='Pagado',1,0)) AS pagos_realizados,
        UPPER(CONCAT_WS(' ', U.nombre,U.apellidos)) AS vendedor,
        CS.empresa_nombre,C.tipo_llamada,
        UPPER(IF(E.como_se_entero IS NULL,'S/R',E.como_se_entero)) AS como_se_entero
    FROM contratos C 
    JOIN convenios CS ON C.convenio_id=CS.id
    LEFT JOIN pagos P ON C.id=P.contrato_id
    JOIN users U2 ON C.user_id=U2.id -- CLIENTE
    LEFT JOIN como_se_entero E ON E.id=U2.como_se_entero
    LEFT JOIN padres PP ON C.padre_id=PP.id
    LEFT JOIN users U ON PP.user_id=U.id -- USUARIO DE SISTEMA
    LEFT JOIN contratos_reservaciones CR ON C.id=CR.contrato_id
    WHERE  DATE(C.created) BETWEEN p_fecha_inicial AND p_fecha_final 
    GROUP BY C.id;

    SET success=1;
    SET message='sp_ventas_filtradoContratos ejecutado correctamente';

END;;
DELIMITER ;

 CALL sp_ventas_filtradoContratos ('{"fecha_inicio":"2024-10-21","fecha_fin":"2024-10-23"}',1, @success,@message,@log);
SELECT @success,@message,@log;

-- https://admon.beneficiosvacacionales.mx/admin/users/13014