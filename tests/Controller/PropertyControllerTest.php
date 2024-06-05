<?php

namespace App\Test\Controller;

use App\Entity\Property;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PropertyControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/uproperty/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Property::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Property index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'property[title]' => 'Testing',
            'property[description]' => 'Testing',
            'property[properties]' => 'Testing',
            'property[price]' => 'Testing',
            'property[surface]' => 'Testing',
            'property[rooms]' => 'Testing',
            'property[bedrooms]' => 'Testing',
            'property[floor]' => 'Testing',
            'property[city]' => 'Testing',
            'property[address]' => 'Testing',
            'property[postalCode]' => 'Testing',
            'property[sold]' => 'Testing',
            'property[parking]' => 'Testing',
            'property[status]' => 'Testing',
            'property[type]' => 'Testing',
            'property[country]' => 'Testing',
            'property[createdAt]' => 'Testing',
            'property[updatedAt]' => 'Testing',
            'property[relation]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Property();
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setProperties('My Title');
        $fixture->setPrice('My Title');
        $fixture->setSurface('My Title');
        $fixture->setRooms('My Title');
        $fixture->setBedrooms('My Title');
        $fixture->setFloor('My Title');
        $fixture->setCity('My Title');
        $fixture->setAddress('My Title');
        $fixture->setPostalCode('My Title');
        $fixture->setSold('My Title');
        $fixture->setParking('My Title');
        $fixture->setStatus('My Title');
        $fixture->setType('My Title');
        $fixture->setCountry('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setRelation('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Property');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Property();
        $fixture->setTitle('Value');
        $fixture->setDescription('Value');
        $fixture->setProperties('Value');
        $fixture->setPrice('Value');
        $fixture->setSurface('Value');
        $fixture->setRooms('Value');
        $fixture->setBedrooms('Value');
        $fixture->setFloor('Value');
        $fixture->setCity('Value');
        $fixture->setAddress('Value');
        $fixture->setPostalCode('Value');
        $fixture->setSold('Value');
        $fixture->setParking('Value');
        $fixture->setStatus('Value');
        $fixture->setType('Value');
        $fixture->setCountry('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setRelation('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'property[title]' => 'Something New',
            'property[description]' => 'Something New',
            'property[properties]' => 'Something New',
            'property[price]' => 'Something New',
            'property[surface]' => 'Something New',
            'property[rooms]' => 'Something New',
            'property[bedrooms]' => 'Something New',
            'property[floor]' => 'Something New',
            'property[city]' => 'Something New',
            'property[address]' => 'Something New',
            'property[postalCode]' => 'Something New',
            'property[sold]' => 'Something New',
            'property[parking]' => 'Something New',
            'property[status]' => 'Something New',
            'property[type]' => 'Something New',
            'property[country]' => 'Something New',
            'property[createdAt]' => 'Something New',
            'property[updatedAt]' => 'Something New',
            'property[relation]' => 'Something New',
        ]);

        self::assertResponseRedirects('/uproperty/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getProperties());
        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getSurface());
        self::assertSame('Something New', $fixture[0]->getRooms());
        self::assertSame('Something New', $fixture[0]->getBedrooms());
        self::assertSame('Something New', $fixture[0]->getFloor());
        self::assertSame('Something New', $fixture[0]->getCity());
        self::assertSame('Something New', $fixture[0]->getAddress());
        self::assertSame('Something New', $fixture[0]->getPostalCode());
        self::assertSame('Something New', $fixture[0]->getSold());
        self::assertSame('Something New', $fixture[0]->getParking());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getCountry());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getRelation());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Property();
        $fixture->setTitle('Value');
        $fixture->setDescription('Value');
        $fixture->setProperties('Value');
        $fixture->setPrice('Value');
        $fixture->setSurface('Value');
        $fixture->setRooms('Value');
        $fixture->setBedrooms('Value');
        $fixture->setFloor('Value');
        $fixture->setCity('Value');
        $fixture->setAddress('Value');
        $fixture->setPostalCode('Value');
        $fixture->setSold('Value');
        $fixture->setParking('Value');
        $fixture->setStatus('Value');
        $fixture->setType('Value');
        $fixture->setCountry('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setRelation('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/uproperty/');
        self::assertSame(0, $this->repository->count([]));
    }
}
