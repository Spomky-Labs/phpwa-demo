'use strict';

import { Controller } from '@hotwired/stimulus';
import { set } from 'idb-keyval';

export default class extends Controller {
  connect = async () => {
    console.warn('JWK Generator Controller connected');
    await this.generateAndStoreKey();
    console.warn('JWK Generation complete');
  }

  generateAndStoreKey = async () => {
    const keyPair = await crypto.subtle.generateKey(
      { name: 'ECDSA', namedCurve: 'P-256' },
      true,
      ['sign', 'verify']
    );

    const pubJwk = await crypto.subtle.exportKey('jwk', keyPair.publicKey);
    const privJwk = await crypto.subtle.exportKey('jwk', keyPair.privateKey);
    const kid = await this.computeJwkThumbprint(pubJwk);

    await set(`auth-key:messages`, {
      privateJwk: privJwk,
      publicJwk: pubJwk,
      kid
    });

    console.warn('Key pair generated and stored:');

    return kid;
  };

  computeJwkThumbprint = async (jwk) => {
    const canonical = {
      crv: jwk.crv,
      kty: jwk.kty,
      x: jwk.x,
      y: jwk.y
    };

    const encoder = new TextEncoder();
    const data = encoder.encode(JSON.stringify(canonical));
    const hash = await crypto.subtle.digest('SHA-256', data);
    const b64 = btoa(String.fromCharCode(...new Uint8Array(hash)));
    return b64.replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '');
  };
}
