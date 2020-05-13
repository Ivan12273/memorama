<?php

use PHPUnit\Framework\TestCase;

final class PuntajesManajerTest extends TestCase
{

    /**
     * @dataProvider entryProviderSetPuntaje
     */
    public function testSetPuntaje($idUsuario, $idMateria, $fecha, $dificultad, $puntaje, $foundPeers)
    {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['insertQuery', 'close'])
            ->getMock();

        // Valores del test cuando se agrega correctamente el puntaje 
        if ($idUsuario == 1) {
            $resultado = true;
            $valorEsperado = '';
        }
        // Valores del test cuando ocurre un problema en el insertQuery
        else {
            $resultado = 'ERROR';
            $valorEsperado = 'ERROR';
        }

        $dbManagerMock->expects($this->exactly(1))
            ->method('insertQuery')
            ->willReturn($resultado);

        $test = new PuntajesManajer($dbManagerMock);
        $this->assertEquals($valorEsperado, $test->setPuntaje($idUsuario, $idMateria, $fecha, $dificultad, $puntaje, $foundPeers));
    }

    public function entryProviderSetPuntaje()
    {
        // id_usuario,id_materia,fecha,dificultad,puntaje,parejas_encontradas
        return [
            'test positivo' => [1, 1, '2020-05-16 02:04:20', 'dificil', 25, 3],
            'test negativo' => [0, 1, '2020-05-16 02:04:20', 'dificil', 25, 3]
        ];
    }

    /**
     * @dataProvider entryProviderDeletePuntaje
     */
    public function testDeletePuntaje($idUsuario, $idMateria, $fecha, $dificultad)
    {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['insertQuery', 'close'])
            ->getMock();

        // Valores del test cuando se elimina correctamente el puntaje solicitado
        if ($idUsuario == 1) {
            $resultado = true;
            $valorEsperado = '';
        }
        // Valores del test cuando ocurre un problema en el insertQuery
        else {
            $resultado = 'ERROR';
            $valorEsperado = 'ERROR';
        }

        $dbManagerMock->expects($this->exactly(1))
            ->method('insertQuery')
            ->willReturn($resultado);

        $test = new PuntajesManajer($dbManagerMock);
        $this->assertEquals($valorEsperado, $test->deletePuntaje($idUsuario, $idMateria, $fecha, $dificultad));
    }

    public function entryProviderDeletePuntaje()
    {
        // $idUsuario,$idMateria,$fecha,$dificultad
        return [
            'test positivo' => [1, 1, '2020-05-16 02:04:20', 'dificil'],
            'test negativo' => [0, 1, '2020-05-16 02:04:20', 'dificil']
        ];
    }

    /**
     * @dataProvider entryProviderGetAllPuntajeForUsuario
     */
    public function testGetAllPuntajeForUsuario($idUsuario)
    {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['realizeQuery', 'close'])
            ->getMock();

        // Valores del test cuando se solicitan los puntajes del usuario 1
        if ($idUsuario == 1) {
            $resultado = [
                '0'  => [
                    'id_usuario' => '1',
                    'id_materia' => '1',
                    'fecha' => '2020-04-16 01:04:20',
                    'dificultad' => 'facil',
                    'puntaje' => '25',
                    'parejas_encontradas' => '0'
                ]
            ];
            $valorEsperado = json_encode($resultado);
        }
        // Valores del test cuando la base de datos está vacía
        else {
            $resultado = null;
            $valorEsperado = 'tabla materia vacia';
        }

        $dbManagerMock->expects($this->exactly(1))
            ->method('realizeQuery')
            ->willReturn($resultado);

        $test = new PuntajesManajer($dbManagerMock);
        $this->assertEquals($valorEsperado, $test->getAllPuntajeForUsuario($idUsuario));
    }

    public function entryProviderGetAllPuntajeForUsuario()
    {
        // $idUsuario
        return [
            'test positivo' => [1],
            'test negativo' => [0]
        ];
    }

    /**
     * @dataProvider entryProviderGetAllPuntajeForMateria
     */
    public function testGetAllPuntajeForMateria($idMateria)
    {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['realizeQuery', 'close'])
            ->getMock();

        // Valores del test cuando se solicitan los puntajes de la materia 1
        if ($idMateria == 1) {
            $resultado = [
                '0'  => [
                    'id_usuario' => '1',
                    'id_materia' => '1',
                    'fecha' => '2020-04-16 01:04:20',
                    'dificultad' => 'facil',
                    'puntaje' => '25',
                    'parejas_encontradas' => '0'
                ]
            ];
            $valorEsperado = json_encode($resultado);
        }
        // Valores del test cuando la base de datos está vacía
        else {
            $resultado = null;
            $valorEsperado = 'tabla materia varia'; // vaRia
        }

        $dbManagerMock->expects($this->exactly(1))
            ->method('realizeQuery')
            ->willReturn($resultado);

        $test = new PuntajesManajer($dbManagerMock);
        $this->assertEquals($valorEsperado, $test->getAllPuntajeForMateria($idMateria));
    }

    public function entryProviderGetAllPuntajeForMateria()
    {
        // $idMateria
        return [
            'test positivo' => [1],
            'test negativo' => [0]
        ];
    }

    /**
     * @dataProvider entryProviderGetAllPuntajeForUsuarioAndMateria
     */
    public function testGetAllPuntajeForUsuarioAndMateria($idUsuario, $idMateria)
    {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['realizeQuery', 'close'])
            ->getMock();

        // Valores del test cuando se solicitan los puntajes del usuario 1 en la materia 1
        if ($idUsuario == 1) {
            $resultado = [
                '0'  => [
                    'id_usuario' => '1',
                    'id_materia' => '1',
                    'fecha' => '2020-04-16 01:04:20',
                    'dificultad' => 'facil',
                    'puntaje' => '25',
                    'parejas_encontradas' => '0'
                ]
            ];
            $valorEsperado = json_encode($resultado);
        }
        // Valores del test cuando la base de datos está vacía
        else {
            $resultado = null;
            $valorEsperado = 'tabla materia varia'; // vaRia
        }

        $dbManagerMock->expects($this->exactly(1))
            ->method('realizeQuery')
            ->willReturn($resultado);

        $test = new PuntajesManajer($dbManagerMock);
        $this->assertEquals($valorEsperado, $test->getAllPuntajeForUsuarioAndMateria($idUsuario, $idMateria));
    }

    public function entryProviderGetAllPuntajeForUsuarioAndMateria()
    {
        // $idUsuario,$idMateria
        return [
            'test positivo' => [1, 1],
            'test negativo' => [0, 1]
        ];
    }

    /**
     * @dataProvider entryProviderCanGetAllScoreForSubjectAndDifficulty
     */
    public function testCanGetAllScoresForSubjectAndDifficulty($idMateria, $dificultad)
    {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['realizeQuery', 'close'])
            ->getMock();

        // Valores del test cuando se solicitan los puntajes del usuario 1 en la materia 1
        if ($idMateria == 1) {
            $resultado = [
                '0'  => [
                    'id_usuario' => '1',
                    'id_materia' => '1',
                    'fecha' => '2020-04-16 01:04:20',
                    'dificultad' => 'facil',
                    'puntaje' => '25',
                    'parejas_encontradas' => '0'
                ]
            ];
            $valorEsperado = json_encode($resultado);
        }
        // Valores del test cuando la base de datos está vacía
        else {
            $resultado = null;
            $valorEsperado = 'tabla materia varia'; // vaRia
        }

        $dbManagerMock->expects($this->exactly(1))
            ->method('realizeQuery')
            ->willReturn($resultado);

        $test = new PuntajesManajer($dbManagerMock);
        $this->assertEquals($valorEsperado, $test->getAllPuntajeForUsuarioAndMateria($idMateria, $dificultad));
    }

    public function entryProviderCanGetAllScoreForSubjectAndDifficulty()
    {

        return [
            'test positivo' => [1, "facil"],
            'test negativo' => [0, "facil"]
        ];
    }

    /**
     * @dataProvider entryProviderCanGetAllScoreForSubjectAndUserAndDifficulty
     */
    public function testCanGetAllScoresForSubjectAndUserAndDifficulty($idUsuario, $idMateria, $dificultad)
    {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['realizeQuery', 'close'])
            ->getMock();

        // Valores del test cuando se solicitan los puntajes del usuario 1 en la materia 1
        if ($idUsuario == 1) {
            $resultado = [
                '0'  => [
                    'id_usuario' => '1',
                    'id_materia' => '1',
                    'fecha' => '2020-04-16 01:04:20',
                    'dificultad' => 'facil',
                    'puntaje' => '25',
                    'parejas_encontradas' => '0'
                ]
            ];
            $valorEsperado = json_encode($resultado);
        }
        // Valores del test cuando la base de datos está vacía
        else {
            $resultado = null;
            $valorEsperado = 'tabla materia varia'; // vaRia
        }

        $dbManagerMock->expects($this->exactly(1))
            ->method('realizeQuery')
            ->willReturn($resultado);

        $test = new PuntajesManajer($dbManagerMock);
        $this->assertEquals($valorEsperado, $test->getAllPuntajeForUsuarioAndMateria($idUsuario, $idMateria, $dificultad));
    }

    public function entryProviderCanGetAllScoreForSubjectAndUserAndDifficulty()
    {

        return [
            'test positivo' => [1, 1, "facil"],
            'test negativo' => [0, 0, "facil"]
        ];
    }
}
