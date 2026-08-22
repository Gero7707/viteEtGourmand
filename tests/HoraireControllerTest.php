<?php
require_once __DIR__ . '/../app/controllers/HoraireController.php';
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class HoraireControllerTest extends TestCase
{
    #[Test]
    public function il_detecte_le_jour_manquant(): void
    {
        // Arrange : une base où seul le dimanche manque
        $horaire = [
            ['jour' => 'Lundi'],
            ['jour' => 'Mardi'],
            ['jour' => 'Mercredi'],
            ['jour' => 'Jeudi'],
            ['jour' => 'Vendredi'],
            ['jour' => 'Samedi'],
        ];

        // Act
        $resultat = HoraireController::calculerJoursManquants($horaire);

        // Assert : on attend uniquement le dimanche
        $this->assertSame(['Dimanche'], array_values($resultat));
    }
    #[Test]
    public function il_detecte_aucun_jour_manquant(): void
    {
        // Arrange : les 7 jours sont présents, aucun ne manque
        $horaire = [
            ['jour' => 'Lundi'],
            ['jour' => 'Mardi'],
            ['jour' => 'Mercredi'],
            ['jour' => 'Jeudi'],
            ['jour' => 'Vendredi'],
            ['jour' => 'Samedi'],
            ['jour' => 'Dimanche'],
        ];

        // Act
        $resultat = HoraireController::calculerJoursManquants($horaire);

        // Assert : on attend un tableau vide
        $this->assertEmpty($resultat);
    }
#[Test]
    public function il_detecte_tous_les_jours_manquant(): void
    {
        // Arrange : la base est vide, aucun jour enregistré
        $horaire = [];

        // Act
        $resultat = HoraireController::calculerJoursManquants($horaire);

        // Assert : on attend les 7 jours, tous manquants
        $this->assertSame(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi', 'Dimanche'], array_values($resultat));
    }

}