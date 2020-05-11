<?php

use PHPUnit\Framework\TestCase;



final class MateriasManagerTest extends Testcase
{
    /**
     * @dataProvider entryProviderCanDeleteSubjects
     */
    public function testCanDeleteSubjects($idMateria) {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
                              ->setMethods(['insertQuery'])
                              ->getMock();

        // Valores del test cuando se elimina correctamente el puntaje solicitado
        if($idMateria == 1) {
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

    public function entryProviderCanDeleteSubjects() {
        // $idMateria
        return [
            'test positivo' => [1], 
            'test negativo' => [0] 
        ];
    }

  
    public function testCanGetAllSubjects() {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
                              ->setMethods(['insertQuery'])
                              ->getMock();

       $resultado = [[
                '0'  => [
                        'id' => '1', 
                        'name' => 'filosofia cuantica',
                      
                    ],
                '1' => [
                        'id' => '2', 
                        'name' => 'Semat',

                    ]]
            ];
            $valorEsperado = json_encode($resultado);

        $dbManagerMock->method('insertQuery')
                      ->willReturn($resultado);

        $test = new MateriasManager($dbManagerMock);
        $this->assertEquals($valorEsperado, $test->getAllMateria());
    }


    public function testCantGetAllSubjects() {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
                              ->setMethods(['realizeQuery'])
                              ->getMock();

       $resultado = null;
       $valorEsperado = 'tabla materia vacia';

        $dbManagerMock->expects($this->exactly(1))
                        ->method('realizeQuery')
                      ->willReturn($resultado);

        $test = new MateriasManager($dbManagerMock);
        $this->assertEquals($valorEsperado, $test->getAllMateria());
    }
 
   public function getMateriaProvider()
   {
     return [
       'test positivo' => [1, "Matematicas"],
       'test negativo' => [5, "Tabla de materias esta vacia"]
     ];
   }
 
   /**
    * @dataProvider getMateriaProvider
    */
   public function testGetMateria($idMateria, $resultado)
   {
     $MatManagerMock = $this->getMockBuilder(MateriasManager::class)
       ->setMethods(['getMateria'])
       ->getMock();
 
     $MatManagerMock->expects($this->exactly(1))
       ->method('getMateria')
       ->willReturn($resultado);
 
     // $dbm = new DataBaseManager();
     $this->assertEquals($resultado, $MatManagerMock->getMateria($idMateria));
   }
    


    

   


}
