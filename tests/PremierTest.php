<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PremierTest extends TestCase
{
    #[Test]
    public function deux_plus_deux_font_quatre(): void
    {
        $resultat = 2 + 2;

        $this->assertSame(4, $resultat);
    }
}