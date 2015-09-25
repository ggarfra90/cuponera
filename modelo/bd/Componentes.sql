--
-- Estructura de tabla para la tabla `componente`
--

CREATE TABLE IF NOT EXISTS `componente` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `CODIGO` varchar(20) NOT NULL,
  `DESCRIPCION` varchar(200) DEFAULT NULL,
  `ESTADO` smallint(6) NOT NULL,
  `CONTROLADOR_URL` varchar(200) NOT NULL,
  `CONTROLADOR_NOMBRE` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `componente`
--

INSERT INTO `componente` (`ID`, `NOMBRE`, `CODIGO`, `DESCRIPCION`, `ESTADO`, `CONTROLADOR_URL`, `CONTROLADOR_NOMBRE`) VALUES
(1, 'arq_tabla', 'arq_tabla', 'Componente de ...', 1, 'cuponera/', '...Controlador');