<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        // $this->addBehavior('Upload');
        $this->addBehavior('ResizeUpload');
        $this->addBehavior('DeleteFile');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->notEmpty('name', 'Este campo é obrigatório');

        $validator
            ->email('email')
            ->notEmpty('email', 'Este campo é obrigatório');

        $validator
            ->scalar('username')
            ->maxLength('username', 50)
            ->notEmpty('username', 'Este campo é obrigatório');

        $validator
            ->scalar('password')
            ->maxLength('password', 220)
            ->notEmpty('password', 'Este campo é obrigatório')
            ->add('password', [
                'length' => [
                    'rule' => ['minLength', 6],
                    'message' => 'A senha deve ter no mínimo 6 caracteres'
                ]
            ]);
        
        $validator
            ->notEmpty('image', 'É obrigatório selecionar a foto')
            ->add('image', 'file', [
                'rule' => ['mimeType', ['image/jpeg', 'image/png']],
                'message' => 'Arquivo inválido. Selecione foto JPEG ou PNG'
            ]);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email'], 'Este e-mail já está cadastrado'));
        $rules->add($rules->isUnique(['username'], 'Este nome de usuário já está sendo utilizado'));

        return $rules;
    }

    public function getUserData($userId)
    {
        return $this->find()->select(['id','name','email','image'])
                              ->where(['Users.id' => $userId])
                              ->first();
    }
}
