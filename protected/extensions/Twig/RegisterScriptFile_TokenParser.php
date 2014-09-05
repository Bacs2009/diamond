<?php
class RegisterScriptFile_TokenParser extends Twig_TokenParser {

    public function parse(Twig_Token $token) {
        $lineno = $token->getLine();
        $this->parser->getStream()->expect(Twig_Token::PUNCTUATION_TYPE, '(');
        $url = $this->parser->getExpressionParser()->parseExpression();

        if ($this->parser->getStream()->test(Twig_Token::PUNCTUATION_TYPE, ')')){
            $this->parser->getStream()->expect(Twig_Token::PUNCTUATION_TYPE, ')');
            $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
            return new RegisterScriptFile_SetNode($url, null, $lineno, $this->getTag());
        }
        $this->parser->getStream()->expect(Twig_Token::PUNCTUATION_TYPE, ',');
        $position = $this->parser->getStream()->expect(Twig_Token::NUMBER_TYPE)->getValue();
        $this->parser->getStream()->expect(Twig_Token::PUNCTUATION_TYPE, ')');
        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
        
        return new RegisterScriptFile_SetNode($url, $position, $lineno, $this->getTag());
    }

    public function getTag() {
        return 'registerScriptFile';
    }
}