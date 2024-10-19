DROP PROCEDURE IF EXISTS sp_configuracion_sistema;
DELIMITER ;;
CREATE PROCEDURE sp_configuracion_sistema ( IN p_json MEDIUMTEXT,IN p_id_usuario INT, OUT success INT,OUT message TEXT,OUT log TEXT)
BEGIN
    DECLARE p_id_padre INT DEFAULT 0;
    DECLARE p_opcion VARCHAR (50);
    DECLARE p_id_pais INT;
    DECLARE p_id_cliente INT;
    DECLARE p_id_tarjeta INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN 
		GET DIAGNOSTICS CONDITION 1 @sqlstate=RETURNED_SQLSTATE,@errno=MYSQL_ERRNO, @text=MESSAGE_TEXT;
        SET success=-1;
		SET message='Lo sentimos, ha ocurrido un error al ejecutar sp_client_resumenSaldos';
		SET log=CONCAT(log," ERROR ", @errno, " (", @sqlstate, "): ", @text);
    END;

    SET success=0;
    SET log='';
    
    
    SET p_opcion=JSON_UNQUOTE(JSON_EXTRACT(p_json, '$.opcion'));
    
    CASE
        WHEN p_opcion='get_bancos'  THEN
            SET p_id_pais=JSON_UNQUOTE(JSON_EXTRACT(p_json, '$.id_pais'));
            SELECT id,title FROM bancos 
            WHERE paise_id=p_id_pais
            ORDER BY title; 
        WHEN p_opcion='get_estatus_reservacion'  THEN
            SELECT * FROM c_estatus_reservacion WHERE activo=1;
        WHEN p_opcion='get_tipo_reservacion'  THEN
            SELECT * FROM c_tipo_reservacion WHERE activo=1;
        WHEN p_opcion='get_tarjetas' THEN
            SET p_id_cliente=JSON_UNQUOTE(JSON_EXTRACT(p_json, '$.id_cliente'));

            SELECT id,banco_id,name,banco,numero,mes,ano,cvv2,estatus 
            FROM tarjetas 
            WHERE user_id=p_id_cliente; 
        
        WHEN p_opcion='tarjeta_por_usuario' THEN
            SET p_id_tarjeta=JSON_UNQUOTE(JSON_EXTRACT(p_json, '$.id_tarjeta'));
            SELECT * FROM tarjetas WHERE id=p_id_tarjeta ; 

        WHEN p_opcion='estatus_tarjetas' THEN
            SELECT estatus FROM tarjetas GROUP BY estatus ORDER BY estatus; 

        WHEN p_opcion='get_estancias' THEN
            SELECT id,solosistema,convenio_id,title,precio,slug,descuento,descripcion,
            tipo,noches,adultos,ninos,edad_max_ninos,caducidad,divisa,cuotas
            FROM estancias
            WHERE habilitada=1 
            AND estancia_paise_id=p_id_pais; 

    END CASE;

    SET success=1;
    SET message='sp_configuracion_sistema ejecutado correctamente';

END ;;
DELIMITER ;

-- CALL sp_configuracion_sistema ('{"id_pais":1,"opcion":"get_bancos"}', @success,@message,@log);
-- SELECT @success,@message,@log;
