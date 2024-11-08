/**
 * @see https://unsplash.com/
 */
class UnsplashImage {

  constructor(imageID, authorID, authorName, url) {

    this.imageID = imageID
    this.imageURL = `https://source.unsplash.com/${imageID}/1920x1080`
    this.authorID = authorID
    this.authorName = authorName
    this.authorURL = `https://unsplash.com/@${authorID}`
    if ((typeof(url) == 'string') && (url.length > 10)) {
        this.imageURL = url;
        this.authorURL = '';
    }

  }

  static getRandom() {

    const images = [
      // new UnsplashImage('pVq6YhmDPtk', 'danranwanghao', 'hao wang'),
      // new UnsplashImage('E8Ufcyxz514', 'fakurian', 'Fakurian Design'),
      // new UnsplashImage('PGdW_bHDbpI', 'fakurian', 'Fakurian Design'),
      // new UnsplashImage('26WixHTutxc', 'gradienta', 'Gradienta'),
      // new UnsplashImage('u8Jn2rzYIps', 'fakurian', 'Fakurian Design'),
      // new UnsplashImage('FBQcPsBL2Zo', 'fakurian', 'Fakurian Design'),
      // new UnsplashImage('Hlkuojv_P6I', 'enginakyurt', 'engin akyurt'),
      // new UnsplashImage('YWIOwHvRBvU', 'pawel_czerwinski', 'Pawel Czerwinski'),
      // new UnsplashImage('', '', '', 'https://spf13.com/p/9-mongodb-2.6-drivers-released/ash-from-modern-afflatus-NQ6Lh81BTRs-unsplash.jpg' ),
      // new UnsplashImage('', '', '', 'https://unsplash.com/photos/a-black-and-white-photo-of-a-cross-in-the-middle-of-a-picture-WEizaiwLk1k' )
      // new UnsplashImage('', '', '', 'assets/images/backgrounds/white-vehicle-1920.jpg' ),
      new UnsplashImage('', '', '', 'assets/images/backgrounds/Rottertram-caret.jpg' ),
      new UnsplashImage('', '', '', 'assets/images/backgrounds/ash.jpg' ),
      new UnsplashImage('', '', '', 'https://418-gersrotterdam.imgix.net/old_website/article_images/0588crop.jpg' ),
      new UnsplashImage('', '', '', 'assets/images/login-background.jpg' )
    ]
    // Select a random image from the list above.
    const image = images[Math.floor(Math.random() * images.length)]

    return image

  }

}

/**
 * MongoDB PHP GUI login.
 */
class Login {

  constructor() {

    this.background = document.getElementById('mpg-background')
    this.backgroundCreditLink = this.background.querySelector('.credit-link')
    this.cardsContainer = document.getElementById('mpg-cards')
    this.flipCardButtons = document.querySelectorAll('.mpg-flip-card-button')
    this.requiredInputs = document.querySelectorAll('input[required]')
    this.forms = document.querySelectorAll('form')

  }

  /**
   * Defines background.
   */
  setBackground() {

    const randomImage = UnsplashImage.getRandom()
    const abortController = new AbortController()

    // We will abort fetch request if it takes more than one second.
    const timeoutID = setTimeout(() => abortController.abort(), 1000)

    fetch(randomImage.imageURL, { signal: abortController.signal })
      .then(response => {
        clearTimeout(timeoutID)
        return response.blob()
      })
      .then(blob => {
        const blobURL = URL.createObjectURL(blob)
        this.background.style.backgroundImage = `url(${blobURL})`
        this.backgroundCreditLink.textContent = `Image by ${randomImage.authorName}`
        this.backgroundCreditLink.href = randomImage.authorURL
        this.cardsContainer.classList.add('reveal')
      })
      .catch(_error => {
        console.warn('Failed to fetch unsplash.com. Fallback to local image.')
        this.background.classList.add('fallback')
        this.cardsContainer.classList.add('reveal')
      })

  }

  /**
   * Adds an event listener on each "Flip card" button.
   */
  listenFlipCardButtons() {

    this.flipCardButtons.forEach(flipCardButton => {
      flipCardButton.addEventListener('click', event => {
        event.preventDefault()
        this.cardsContainer.classList.toggle('flipped')
      })
    })

  }

  /**
   * Adds an event listener on each required input field.
   */
  listenRequiredInputs() {

    this.cardsContainer.addEventListener('animationend', _event => {
      this.cardsContainer.classList.remove('shake')
    })

    this.requiredInputs.forEach(requiredInput => {
      requiredInput.addEventListener('invalid', _event => {
        this.cardsContainer.classList.add('shake')
      })
    })

  }

  /**
   * Adds an event listener on each form.
   */
  listenForms() {

    this.forms.forEach(form => {
      form.addEventListener('submit', event => {
        event.preventDefault()

        /**
         * TODO: Submit form if credentials are good.
         *
         * @see https://github.com/SamuelTallet/MongoDB-PHP-GUI/issues/21
         */
        form.submit()
      })
    })

  }

}

(function onDocumentReady() {

  const login = new Login()

  login.setBackground()
  login.listenFlipCardButtons()
  login.listenRequiredInputs()
  login.listenForms()

})()
