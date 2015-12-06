<?php
/**
 * DateFormat.php
 *
 * @copyright	More in license.md
 * @license		http://www.ipublikuj.eu
 * @author		Adam Kadlec http://www.ipublikuj.eu
 * @package		iPublikuj:Doctrine!
 * @subpackage	String functions
 * @since		5.0
 *
 * @date		29.01.14
 */

namespace IPub\Doctrine\StringFunctions;

use Doctrine;
use Doctrine\ORM\Query;

class DateFormat extends Query\AST\Functions\FunctionNode
{
	/**
	 * Holds the timestamp of the DATE_FORMAT DQL statement
	 *
	 * @var mixed
	 */
	protected $dateExpression;

	/**
	 * Holds the '%format' parameter of the DATE_FORMAT DQL statement
	 *
	 * @var string
	 */
	protected $formatChar;

	/**
	 * @param Query\SqlWalker $sqlWalker
	 *
	 * @return string
	 */
	public function getSql(Query\SqlWalker $sqlWalker)
	{
		return 'DATE_FORMAT(' .
			$sqlWalker->walkArithmeticExpression($this->dateExpression) .
			','.
			$sqlWalker->walkStringPrimary($this->formatChar) .
		')';
	}

	/**
	 * @param Query\Parser $parser
	 *
	 * @return void
	 */
	public function parse(Query\Parser $parser)
	{
		$parser->match(Query\Lexer::T_IDENTIFIER);
		$parser->match(Query\Lexer::T_OPEN_PARENTHESIS);

		$this->dateExpression = $parser->ArithmeticExpression();
		$parser->match(Query\Lexer::T_COMMA);

		$this->formatChar = $parser->StringPrimary();
		$parser->match(Query\Lexer::T_CLOSE_PARENTHESIS);
	}
}