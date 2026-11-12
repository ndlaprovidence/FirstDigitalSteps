<?php

namespace App\Tests\Controller;

use App\Entity\Slide;
use App\Repository\SlideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SlideControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    /** @var EntityRepository<Slide> $slideRepository */
    private EntityRepository $slideRepository;
    private string $path = '/slide/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->slideRepository = $this->manager->getRepository(Slide::class);

        foreach ($this->slideRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Slide index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'slide[title]' => 'Testing',
            'slide[Position]' => 'Testing',
            'slide[Image]' => 'Testing',
            'slide[SlideShow]' => 'Testing',
        ]);

        self::assertResponseRedirects('/slide');

        self::assertSame(1, $this->slideRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new Slide();
        $fixture->setTitle('My Title');
        $fixture->setPosition('My Title');
        $fixture->setImage('My Title');
        $fixture->setSlideShow('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Slide');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new Slide();
        $fixture->setTitle('Value');
        $fixture->setPosition('Value');
        $fixture->setImage('Value');
        $fixture->setSlideShow('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'slide[title]' => 'Something New',
            'slide[Position]' => 'Something New',
            'slide[Image]' => 'Something New',
            'slide[SlideShow]' => 'Something New',
        ]);

        self::assertResponseRedirects('/slide');

        $fixture = $this->slideRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getPosition());
        self::assertSame('Something New', $fixture[0]->getImage());
        self::assertSame('Something New', $fixture[0]->getSlideShow());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new Slide();
        $fixture->setTitle('Value');
        $fixture->setPosition('Value');
        $fixture->setImage('Value');
        $fixture->setSlideShow('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/slide');
        self::assertSame(0, $this->slideRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
