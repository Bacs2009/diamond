<?php
class Cache_TokenParser extends Twig_TokenParser {

    public function parse(Twig_Token $token) {
        $lineno = $token->getLine();
        //$name = $this->parser->getStream()->expect(Twig_Token::NAME_TYPE)->getValue();
        //$this->parser->getStream()->expect(Twig_Token::PUNCTUATION_TYPE, '(');
        //$value = $this->parser->getExpressionParser()->parseExpression();
        $key = $this->parser->getStream()->expect(Twig_Token::STRING_TYPE)->getValue();
        //$this->parser->getStream()->expect(Twig_Token::PUNCTUATION_TYPE, ',');
        //$value = $this->parser->getExpressionParser()->parseExpression();
        if ($this->parser->getStream()->test(Twig_Token::BLOCK_END_TYPE)){
            $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
            return new Cache_SetNode($key, null, $lineno, $this->getTag());
        }
        $duration = $this->parser->getStream()->expect(Twig_Token::NUMBER_TYPE)->getValue();
        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
        
        return new Cache_SetNode($key, $duration, $lineno, $this->getTag());
    }

    public function getTag() {
        return 'cache';
    }
}