$property = new Property($entityManager);
        $property->setTitle('Mon bien 1')
                 ->setDescription('Description de mon bien 1')
                 ->setSurface(600)
                 ->setRooms(10)
                 ->setBedrooms(6)
                 ->setFloor(2)
                 ->setCity('Antananarivo')
                 ->setAddress('67ha')
                 ->setPostalCode('101')
                 ->setparking(0)
                 ->setStatus(1)
                 ->setType(1)
                 ->setPrice(20000000);
                 $entityManager->persist($property); // Utilisez l'EntityManager
                 $entityManager->flush(); // Utilisez l'EntityManager


        $property1 = new Property($entityManager);
        $property1 ->setTitle('Mon bien 2')
                 ->setDescription('Description de mon bien 2')
                 ->setSurface(700)
                 ->setRooms(9)
                 ->setBedrooms(6)
                 ->setFloor(2)
                 ->setCity('Manjunga')
                 ->setAddress('67ha')
                 ->setPostalCode('101')
                 ->setparking(1)
                 ->setStatus(1)
                 ->setType(2)
                 ->setPrice(30000000);
       
                 $entityManager->persist($property1); // Utilisez l'EntityManager
                 $entityManager->flush(); // Utilisez l'EntityManager

        $property2 = new Property($entityManager);
        $property2 ->setTitle('Mon bien 3')
                 ->setDescription('Description de mon bien 3')
                 ->setSurface(900)
                 ->setRooms(9)
                 ->setBedrooms(6)
                 ->setFloor(2)
                 ->setCity('Antsirabe')
                 ->setAddress('67ha')
                 ->setPostalCode('101')
                 ->setparking(2)
                 ->setStatus(1)
                 ->setType(0)
                 ->setPrice(40000000);
                

                 $entityManager->persist($property2); // Utilisez l'EntityManager
                 $entityManager->flush(); // Utilisez l'EntityManager





                 #[Route('/biens/{slug}-{id<[0-9]+>}', name: 'app_property_show', requirements: ['slug' => '[a-z0-9\-]*'])]

public function show(Property $property, string $slug): Response
{
    if ($property->getSlug() !== $slug) {
        return $this->redirectToRoute('app_property_show', [
            'id' => $property->getId(),
            'slug' => $property->getSlug(),
        ], 301);
    }

    return $this->render('property/show.html.twig', [
        'property' => $property,
        'current_menu' => 'properties',
    ]);
}


<nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
    <div class="container">
      <!-- <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </button> -->
      <a class="navbar-brand text-brand" href="{{ path('app_home') }}">SEIMAD<span class="color-b" style="color : #0565f7;">SA</span></a>


      <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="{{ path('app_home') }}">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ path('app_presentation' )}}">Présentation</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ path('app_property') }}">Nos Projets</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{path('app_actualite_index')}}">Actualités</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Nos Réalisation</a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Antananarivo</a>
            <a class="dropdown-item" href="#">Mahajanga</a>
            <a class="dropdown-item" href="#">Toamasina</a>
            <a class="dropdown-item" href="#">Fianarantsoa</a>
            <a class="dropdown-item" href="#">Antsiranana</a>
            <a class="dropdown-item" href="#">Toliara</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ path('app_contact')}} ">Contact</a>
        </li>
      </ul>
      </div>
      <!-- <form class="form-inline my-2 my-lg-0" role="search" action="{{ path('app_recherche')}}" method="GET">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="un mot clé" aria-label="Search">
      </form>
              <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Chercher</button>
              <div class="col-auto d-flex">
              <a class="btn btn-primary ml-auto" href="{{path('app_manifesat_interet')}}">Manifestation d'intérêt</a>
              </div> -->
    </div>
  </nav>