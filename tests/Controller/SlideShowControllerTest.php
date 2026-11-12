<?php

namespace App\Tests\Controller;

use App\Entity\SlideShow;
use App\Repository\SlideShowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SlideShowControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    /** @var EntityRepository<SlideShow> $slideShowRepository */
    private EntityRepository $slideShowRepository;
    private string $path = '/slide/show/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->slideShowRepository = $this->manager->getRepository(SlideShow::class);

        foreach ($this->slideShowRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SlideShow index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'slide_show[title]' => 'Testing',
            'slide_show[Image]' => 'Testing',
            'slide_show[Theme]' => 'Testing',
        ]);

        self::assertResponseRedirects('/slide/show');

        self::assertSame(1, $this->slideShowRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new SlideShow();
        $fixture->setTitle('My Title');
        $fixture->setImage('My Title');
        $fixture->setTheme('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SlideShow');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new SlideShow();
        $fixture->setTitle('Value');
        $fixture->setImage('Value');
        $fixture->setTheme('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'slide_show[title]' => 'Something New',
            'slide_show[Image]' => 'Something New',
            'slide_show[Theme]' => 'Something New',
        ]);

        self::assertResponseRedirects('/slide/show');

        $fixture = $this->slideShowRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getImage());
        self::assertSame('Something New', $fixture[0]->getTheme());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new SlideShow();
        $fixture->setTitle('Value');
        $fixture->setImage('Value');
        $fixture->setTheme('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/slide/show');
        self::assertSame(0, $this->slideShowRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
