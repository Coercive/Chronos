<?php
namespace Coercive\Utility\Chronos;

/**
 * Chronos
 * PHP Version 	5
 *
 * @version		1
 * @package 	Coercive\Utility\Chronos
 * @link		@link https://github.com/Coercive/Chronos
 *
 * @author  	Anthony Moral <contact@coercive.fr>
 * @copyright   2016 - 2017 Anthony Moral
 * @license 	http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
class Chronos {

	/** @var int MicroTime Start Value */
	static private $_iMicroTimeStart = 0;

	/** @var string ProjectName */
	static private $_sProjectName = 'Coercive_Chronos';

	/**
	 * GET/SET PROJECTNAME FOR LOGS
	 *
	 * @param string $sProjectName
	 * @return string
	 */
	static public function projectName($sProjectName = '') {
		return $sProjectName ? self::$_sProjectName = $sProjectName : self::$_sProjectName;
	}

	/**
	 * Temps d'execution d'un script
	 *
	 * @return array
	 */
	static public function interval() {

		/** @var int $iServerTime :: Temps d'execution script serveur */
		$iServerTime = microtime(true) - (isset($_SERVER['REQUEST_TIME_FLOAT']) ? $_SERVER['REQUEST_TIME_FLOAT'] : 0);

		/** @var int $iDiff :: Temps d'ecart entre start et end en secondes */
		$iDiff = self::$_iMicroTimeStart ? $iServerTime - self::$_iMicroTimeStart : NULL;

		# LOG : Affichage des temps d'executions
		if(!$iDiff) {
			error_log(print_r('-----------------------------------------', true));
			error_log(print_r('--------- Execution Script Time ---------', true));
			error_log(print_r('Project : ' . self::projectName(), true));
		}
		error_log(print_r("Script Time : $iServerTime secondes.", true));
		if($iDiff) {
			error_log(print_r("Diff   Time : $iDiff secondes.", true));
			error_log(print_r('-----------------------------------------', true));
		}

		# SET FUTUR MICRO TIME
		self::$_iMicroTimeStart = self::$_iMicroTimeStart ? 0 : $iServerTime;

		# RETURN ARRAY
		return ['SERVER_TIME'=>$iServerTime, 'DIFF'=>$iDiff];
	}

	/**
	 * SINGLE SHOT
	 * Temps d'execution d'un script
	 *
	 * @return array
	 */
	static public function single() {

		/** @var int $iServerTime :: Temps d'execution script serveur */
		$iServerTime = microtime(true) - (isset($_SERVER['REQUEST_TIME_FLOAT']) ? $_SERVER['REQUEST_TIME_FLOAT'] : 0);

		# LOG : Affichage des temps d'executions
		error_log(print_r('-----------------------------------------', true));
		error_log(print_r('------ Calcul du temps d\'execution ------', true));
		error_log(print_r('Project : ' . self::projectName(), true));
		error_log(print_r("Script Time : $iServerTime secondes.", true));
		error_log(print_r('-----------------------------------------', true));

		# RETURN ARRAY
		return ['SERVER_TIME'=>$iServerTime, 'DIFF'=>0];
	}

}