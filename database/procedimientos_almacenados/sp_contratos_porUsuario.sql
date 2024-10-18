DROP PROCEDURE IF EXISTS sp_contratos_porUsuario;
DELIMITER ;;
CREATE PROCEDURE sp_contratos_porUsuario (IN p_id_usuario INT, OUT success INT,OUT message TEXT,OUT log TEXT)
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
    
    SELECT id INTO p_id_padre FROM padres WHERE user_id = p_id_usuario LIMIT 1;

    SELECT C.id,CS.empresa_nombre,
    GROUP_CONCAT(DISTINCT U.id) AS id_cliente,U.username,
    UPPER(CONCAT_WS(' ',U.nombre,U.apellidos)) AS nombre_cliente,E.title,C.created
    FROM contratos C 
    JOIN users U ON U.id=C.user_id 
    JOIN convenios CS ON C.convenio_id=CS.id 
    JOIN estancias E ON E.id=C.estancia_id
    WHERE C.padre_id=p_id_padre
    GROUP BY C.id;

    SET success=1;
    SET message='sp_contratos_porUsuario ejecutado correctamente';

END ;;
DELIMITER ;

-- CALL sp_contratos_porUsuario (684289, @success,@message,@log);
-- SELECT @success,@message,@log;
