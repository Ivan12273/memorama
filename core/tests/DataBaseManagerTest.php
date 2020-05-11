<?php

//declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class DataBaseManagerTest extends TestCase
{

  public function insertQueryProvider()
  {
    return [
      'test positivo' => [3, true, 'Español'],
      'test negativo' => [1, false, 'Matematicas']
    ];
  }
  /**
   * @dataProvider insertQueryProvider
   */
  public function testInsertQuery($idMateria, $resultado, $nombre)
  {
    $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
      ->setMethods(['insertQuery'])
      ->getMock();

    $dbManagerMock->expects($this->exactly(1))
      ->method('insertQuery')
      ->willReturn($resultado);

    $this->assertEquals($resultado, $dbManagerMock->insertQuery("INSERT INTO `materias`(`id`, `nombre`) VALUES (" . $idMateria . ", '" . $nombre . "')"));
  }

  public function realizeQueryProvider()
  {
    return [
      'test positivo' => [1, array('El 1' , 'El 2')],
      'test negativo' => [5, null]
    ];
  }

  /**
   * @dataProvider realizeQueryProvider
   */
  public function testRealizeQuery($idMateria, $resultado)
  {
    $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
      ->setMethods(['realizeQuery'])
      ->getMock();

    $dbManagerMock->expects($this->exactly(1))
      ->method('realizeQuery')
      ->willReturn($resultado);

    if ($idMateria == 1) {
      $this->assertIsArray($dbManagerMock->realizeQuery("SELECT nombre FROM `materias` WHERE id=" . $idMateria . ""));
    } else {
      $this->assertIsNotArray($dbManagerMock->realizeQuery("SELECT nombre FROM `materias` WHERE id=" . $idMateria . ""));
    }
  }

  public function closeProvider()
  {
    return [
      'test positivo' => [true, true],
      'test negativo' => [false, null]
    ];
  }


  /** @dataProvider closeProvider */
  public function testClose($existeConexion, $resultado)
  {
    $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
      ->setMethods(['close'])
      ->getMock();

    $dbManagerMock->expects($this->exactly(1))
      ->method('close')
      ->willReturn($resultado);

    if ($existeConexion) {
      $this->assertEquals($resultado, $dbManagerMock->close());
    } else {
      $this->assertEquals($resultado, $dbManagerMock->close());
    }
  }
}
