<?php

use PHPUnit\Framework\TestCase;

final class ParejasManagerTest extends TestCase
{

  /**
   * @dataProvider entryProviderGetPareja
   */
  public function testGetPareja($id, $idMateria)
  {
    $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
      ->disableOriginalConstructor()
      ->setMethods(['realizeQuery', 'close'])
      ->getMock();

    if ($id == 1) {
      $resultado = [
        '1' => [
          'id' => '1',
          'id_materia' => '1',
          'concepto' => 'dosmasdos',
          'descripcion' => 'cuatro'
        ]
      ];
      $valorEsperado = json_encode($resultado);;
    } else {
      $resultado = '';
      $valorEsperado = 'tabla de parejas vacia';
    }

    $dbManagerMock->expects($this->once())
      ->method('realizeQuery')
      ->willReturn($resultado);

    $test = new ParejasManager($dbManagerMock);
    $this->assertEquals($valorEsperado, $test->getPareja($id, $idMateria));
  }

  public function entryProviderGetPareja()
  {
    // id_materia, id
    return [
      'test positivo' => [1, 1],
      'test negativo' => [0, 1]
    ];
  }

  /**
   * @dataProvider entryProviderSetPareja
   */
  public function testSetPareja($idMateria, $concepto, $descripcion)
  {
    $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
      ->disableOriginalConstructor()
      ->setMethods(['insertQuery', 'close'])
      ->getMock();

    if ($idMateria == 1) {
      $resultado = true;
      $valorEsperado = '';
    } else {
      $resultado = 'ERROR';
      $valorEsperado = 'ERROR';
    }

    $dbManagerMock->expects($this->exactly(1))
      ->method('insertQuery')
      ->willReturn($resultado);

    $test = new ParejasManager($dbManagerMock);
    $this->assertEquals($valorEsperado, $test->setPareja($idMateria, $concepto, $descripcion));
  }

  public function entryProviderSetPareja()
  {
    // id_materia, concepto, descripcion
    return [
      'test positivo' => [1, "nuevemasnueve", "dieciocho"],
      'test negativo' => [0, "nuevemasnueve", "dieciocho"]
    ];
  }

  /**
   * @dataProvider entryProviderUpdatePareja
   */
  public function testUpdatePareja($id, $idMateria, $concepto, $descripcion)
  {
    $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
      ->disableOriginalConstructor()
      ->setMethods(['insertQuery', 'close'])
      ->getMock();

    if ($id == 1) {
      $resultado = true;
      $valorEsperado = '';
    } else {
      $resultado = 'ERROR';
      $valorEsperado = 'ERROR';
    }

    $dbManagerMock->expects($this->exactly(1))
      ->method('insertQuery')
      ->willReturn($resultado);

    $test = new ParejasManager($dbManagerMock);
    $this->assertEquals($valorEsperado, $test->updatePareja($id, $idMateria, $concepto, $descripcion));
  }

  public function entryProviderUpdatePareja()
  {
    // id, id_materia, concepto, descripcion
    return [
      'test positivo' => [1, 1, "nuevemasnueve", "dieciocho"],
      'test negativo' => [0, 1, "nuevemasnueve", "dieciocho"]
    ];
  }

  /**
   * @dataProvider entryProviderDeletePareja
   */
  public function testDeletePareja($id, $idMateria)
  {
    $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
      ->disableOriginalConstructor()
      ->setMethods(['insertQuery', 'close'])
      ->getMock();

    if ($id == 1) {
      $resultado = true;
      $valorEsperado = '';
    } else {
      $resultado = 'ERROR';
      $valorEsperado = 'ERROR';
    }


    $dbManagerMock->expects($this->exactly(1))
      ->method('insertQuery')
      ->willReturn($resultado);

    $test = new ParejasManager($dbManagerMock);
    $this->assertEquals($valorEsperado, $test->deletePareja($id, $idMateria));
  }

  public function entryProviderDeletePareja()
  {
    // id, id_materia
    return [
      'test positivo' => [1, 1],
      'test negativo' => [0, 1]
    ];
  }
}
