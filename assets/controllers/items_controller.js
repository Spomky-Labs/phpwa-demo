import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['list', 'message']
    static values = {
        collectionUrl: String,
    }
    // ...
  connect() {
    this.messageTarget.innerHTML = 'fetching ' + this.collectionUrlValue;
    this.loadList();
  }

  async loadList() {
    try {
      // this endpoint will return CORS error
      const response = await fetch(this.collectionUrlValue);
      if (!response.ok) {
        return;
      } else {
        // promise resolved.
        const items = await response.json();
        const count = items['hydra:totalItems'];
        this.messageTarget.innerHTML = `${count} total items`;
      }
    } catch {
      this.messageTarget.innerHTML = 'unable to fetch items at this time.';
      console.error('Failed');
      return;
    }
  }

  refresh() {
      this.loadList();
  }

}
