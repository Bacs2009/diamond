<?php
class BeginWidget_TokenParser extends Twig_TokenParser {

    public function parse(Twig_Token $token) {
        $lineno = $token->getLine();
        //$name = $this->parser->getStream()->expect(Twig_Token::NAME_TYPE)->getValue();
        $this->parser->getStream()->expect(Twig_Token::PUNCTUATION_TYPE, '(');
        //$value = $this->parser->getExpressionParser()->parseExpression();
        $class = $this->parser->getStream()->expect(Twig_Token::STRING_TYPE)->getValue();
        $this->parser->getStream()->expect(Twig_Token::PUNCTUATION_TYPE, ',');
        $value = $this->parser->getExpressionParser()->parseExpression();
        $this->parser->getStream()->expect(Twig_Token::PUNCTUATION_TYPE, ')');
        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
        
        return new BeginWidget_SetNode($class, $value, $lineno, $this->getTag());
    }

    public function getTag() {
        return 'beginWidget';
    }
}