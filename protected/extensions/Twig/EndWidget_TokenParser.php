<?php
class EndWidget_TokenParser extends Twig_TokenParser {

    public function parse(Twig_Token $token) {
        $lineno = $token->getLine();
        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
        
        return new EndWidget_SetNode($lineno, $this->getTag());
    }

    public function getTag() {
        return 'endWidget';
    }
}