<?php

use PHPUnit\Framework\TestCase;

final class UserManagerTest extends TestCase
{
    /**
     * @dataProvider entryProviderSetUser
     */
    public function testSetUser($name, $password, $tipo)
    {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['insertQuery', 'close'])
            ->getMock();

        // Resultado esperado cuando se agregan correctamente los datos 
        if ($name != null) {
            $resultado = true;
            $valorEsperado = '';
        }
        // Resultado esperado cuando ocurre un problema en la solicitud
        else {
            $resultado = 'ERROR';
            $valorEsperado = 'ERROR';
        }

        $dbManagerMock->expects($this->exactly(1))
            ->method('insertQuery')
            ->willReturn($resultado);

        $test = new UserManager($dbManagerMock);
        $this->assertEquals($valorEsperado, $test->setUser($name, $password, $tipo));
    }

    public function entryProviderSetUser()
    {
        // nombre,tipo,clave
        return [
            'test positivo' => ['randomName', 'password', 0],
            'test negativo' => [null, 'password', 0]
        ];
    }

    /**
     * @dataProvider entryProviderUpdateUser
     */
    public function testUpdateUser($id, $name, $password, $tipo)
    {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['insertQuery', 'close'])
            ->getMock();

        // Resultado esperado cuando existen los datos
        if ($id == 0) {
            $resultado = true;
            $valorEsperado = '';
        }
        // Resultado esperado cuando ocurre un problema en la solicitud
        else {
            $resultado = 'ERROR';
            $valorEsperado = 'ERROR';
        }

        $dbManagerMock->expects($this->exactly(1))
            ->method('insertQuery')
            ->willReturn($resultado);

        $test = new UserManager($dbManagerMock);
        $this->assertEquals($valorEsperado, $test->updateUser($id, $name, $password, $tipo));
    }

    public function entryProviderUpdateUser()
    {
        // id,nombre,tipo,clave
        return [
            'test positivo' => [0, 'newName', 'newPassword', 1],
            'test negativo' => [5, 'newName', 'newPassword', 1]
        ];
    }

    /**
     * @dataProvider entryProviderGetUser
     */
    public function testGetUser($name, $password)
    {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['realizeQuery', 'close'])
            ->getMock();

        // Valores del test cuando se solicitan el usuario con nombre 'usuario'
        if ($name == 'usuario') {
            $resultado = [
                '0'  => [
                    'id' => 0,
                    'nombre' => 'usuario',
                    'tipo' => 0,
                    'clave' => 'memopass'
                ]
            ];
            $valorEsperado = json_encode($resultado);
        }
        // Valores del test cuando la base de datos está vacía
        else {
            $resultado = null;
            $valorEsperado = 'Tabla usuario vacia';
        }

        $dbManagerMock->expects($this->exactly(1))
            ->method('realizeQuery')
            ->willReturn($resultado);

        $test = new UserManager($dbManagerMock);
        $this->assertEquals($valorEsperado, $test->getUser($name, $password));
    }

    public function entryProviderGetUser()
    {
        // nombre, clave
        return [
            'test positivo' => ['usuario', 'memopass'],
            'test negativo' => ['noExistent', 'noPassDefined']
        ];
    }

    /**
     * @dataProvider entryProviderGetUserById
     */
    public function testGetUserById($id)
    {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['realizeQuery', 'close'])
            ->getMock();

        // Valores del test cuando se solicitan el usuario con nombre 'usuario'
        if ($id == 0) {
            $resultado = [
                '0'  => [
                    'id' => 0,
                    'nombre' => 'usuario',
                    'tipo' => 0,
                    'clave' => 'memopass'
                ]
            ];
            $valorEsperado = json_encode($resultado);
        }
        // Valores del test cuando la base de datos está vacía
        else {
            $resultado = null;
            $valorEsperado = 'Tabla usuario vacia';
        }

        $dbManagerMock->expects($this->exactly(1))
            ->method('realizeQuery')
            ->willReturn($resultado);

        $test = new UserManager($dbManagerMock);
        $this->assertEquals($valorEsperado, $test->getUserById($id));
    }

    public function entryProviderGetUserById()
    {
        // $id
        return [
            'test positivo' => [0],
            'test negativo' => [23]
        ];
    }

    /**
     * @dataProvider entryProviderDeleteUser
     */
    public function testDeleteUser($UserId)
    {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['insertQuery', 'close'])
            ->getMock();

        // Resultado esperado cuando existen los datos
        if ($UserId == 0) {
            $resultado = true;
            $valorEsperado = '';
        }
        // Resultado esperado cuando ocurre un problema en la solicitud
        else {
            $resultado = 'ERROR';
            $valorEsperado = 'ERROR';
        }

        $dbManagerMock->expects($this->exactly(1))
            ->method('insertQuery')
            ->willReturn($resultado);

        $test = new UserManager($dbManagerMock);
        $this->assertEquals($valorEsperado, $test->deleteUser($UserId));
    }

    public function entryProviderDeleteUser()
    {
        // id
        return [
            'test positivo' => [0],
            'test negativo' => [5]
        ];
    }

    public function testCanGetAllUsers()
    {
        $dbManagerMock = $this->getMockBuilder(DataBaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['realizeQuery', 'close'])
            ->getMock();

        $resultado = array(
            [
                'id' => '1',
                'nombre' => 'ivan',
                'tipo' => '0',
                'clave' => '123'
            ],
            [
                'id' => '2',
                'nombre' => 'ivanMaster',
                'tipo' => '1',
                'clave' => '123'
            ]
        );

        $coded[] = $this->setValuesToResult($resultado);
        $valorEsperado = json_encode($coded);

        $dbManagerMock->method('realizeQuery')
            ->willReturn($resultado);

        $test = new UserManager($dbManagerMock);
        $this->assertEquals($valorEsperado, $test->getAllUsers());
    }

    //--------------------------------------------------------------------------------------------
    private function setValuesToResult($result){
        $users = array();
        for ($i=0;$i<count($result);$i++) {
            $users['id'] = $result[$i]['id'];
            $users['name'] = $result[$i]['nombre'];
            $users['type'] = $result[$i]['tipo'];
            $users['password'] = $result[$i]['clave'];

            $usersList[] = $users;

        }

        return $usersList;
    }
}
