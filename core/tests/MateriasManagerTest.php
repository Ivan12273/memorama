<?php

use PHPUnit\Framework\TestCase;



final class MateriasManagerTest extends Testcase
{
  /**
   * @dataProvider entryProviderCanDeleteSubjects
   */
  public function testCanDeleteSubjects($idMateria)
  {
    $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
      ->disableOriginalConstructor()
      ->setMethods(['insertQuery', 'close'])
      ->getMock();

    // Valores del test cuando se elimina correctamente el puntaje solicitado
    if ($idMateria == 1) {
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

    $test = new MateriasManager($dbManagerMock);
    $this->assertEquals($valorEsperado, $test->deleteMateria($idMateria));
  }

  public function entryProviderCanDeleteSubjects()
  {
    // $idMateria
    return [
      'test positivo' => [1],
      'test negativo' => [0]
    ];
  }


  public function testCanGetAllSubjects()
  {
    $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
      ->disableOriginalConstructor()
      ->setMethods(['realizeQuery', 'close'])
      ->getMock();

    $resultado = array(
      [
        'id' => '1',
        'nombre' => 'filosofia cuantica',

      ],
      [
        'id' => '2',
        'nombre' => 'Semat',
      ]
    );
    $coded[] = $this->setValuesToResult($resultado);
    $valorEsperado = json_encode($coded);

    $dbManagerMock->expects($this->exactly(1))
      ->method('realizeQuery')
      ->willReturn($resultado);

    $test = new MateriasManager($dbManagerMock);
    $this->assertEquals($valorEsperado, $test->getAllMateria());
  }


  /**
   * @dataProvider getMateriaProvider
   */
  public function testGetMateria($idMateria, $resultado)
  {
    $MatManagerMock = $this->getMockBuilder(MateriasManager::class)
      ->disableOriginalConstructor()
      ->setMethods(['getMateria', 'close'])
      ->getMock();

    $MatManagerMock->expects($this->exactly(1))
      ->method('getMateria')
      ->willReturn($resultado);

    $this->assertEquals($resultado, $MatManagerMock->getMateria($idMateria));
  }

  public function getMateriaProvider()
  {
    return [
      'test positivo' => [1, "Matematicas"],
      'test negativo' => [5, "Tabla de materias esta vacia"]
    ];
  }

  //--------------------------------------------------------------------------------------------
  private function setValuesToResult($result)
  {
    $matter = array();
    for ($i = 0; $i < count($result); $i++) {
      $matter['id'] = $result[$i]['id'];
      $matter['name'] = $result[$i]['nombre'];

      $matterList[] = $matter;
    }

    return $matterList;
  }
}
