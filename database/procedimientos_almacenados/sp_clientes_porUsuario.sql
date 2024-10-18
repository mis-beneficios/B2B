DROP PROCEDURE IF EXISTS sp_clientes_porUsuario;
DELIMITER ;;
CREATE PROCEDURE sp_clientes_porUsuario (IN p_id_usuario INT, OUT success INT,OUT message TEXT,OUT log TEXT)
BEGIN
    DECLARE p_id_padre INT DEFAULT 0;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN 
		GET DIAGNOSTICS CONDITION 1 @sqlstate=RETURNED_SQLSTATE,@errno=MYSQL_ERRNO, @text=MESSAGE_TEXT;
        SET success=-1;
		SET message='Lo sentimos, ha ocurrido un error al ejecutar sp_clientes_porUsuario';
		SET log=CONCAT(log," ERROR ", @errno, " (", @sqlstate, "): ", @text);
    END;

    SET success=0;
    SET log='';
    SELECT id INTO p_id_padre FROM padres WHERE user_id = p_id_usuario LIMIT 1;

    SELECT C.user_id,C.paquete,CS.empresa_nombre,
    UPPER(CONCAT_WS(' ',U.NOMBRE,U.apellidos)) AS nombre_cliente, U.username,
    U.created
    FROM contratos C 
    JOIN convenios CS ON C.convenio_id=CS.id
    JOIN users U ON U.id=C.user_id
    WHERE C.padre_id = p_id_padre
    GROUP BY C.user_id
    ORDER BY 4;

    SET success=1;
    SET message='sp_clientes_porUsuario ejecutado correctamente';

END ;;
DELIMITER ;

-- CALL sp_clientes_porUsuario (684289, @success,@message,@log);
-- SELECT @success,@message,@log;
