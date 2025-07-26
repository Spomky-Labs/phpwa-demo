'use strict';

import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static targets = ['destination', 'startButton', 'stopButton', 'downloadButton', 'audioSelect', 'videoSelect', 'videoQualitySelect', 'audioQualitySelect', 'frameRateInput'];
  chunks = [];
  mimeType = null;
  connect() {
    this.populateSources();
    window.addEventListener('pwa--capture:recorder:start', event => this.start(event));
    window.addEventListener('pwa--capture:recorder:data', event => this.data(event));
    window.addEventListener('pwa--capture:recorder:stop', () => this.stop());
  }

  media =() => {
    const audioId = this.hasAudioSelectTarget ? this.audioSelectTarget.value : null;
    const videoId = this.hasVideoSelectTarget.value ? this.videoSelectTarget.value : null;
    const constraints = this.getConstraints();
    if (constraints.audio === true) {
      constraints.audio = { deviceId: audioId ? { exact: audioId } : undefined };
    } else {
      constraints.audio.deviceId = audioId ? { exact: audioId } : undefined;
    }

    if (constraints.video === true) {
      constraints.video = { deviceId: videoId ? { exact: videoId } : undefined };
    } else {
      constraints.video.deviceId = videoId ? { exact: videoId } : undefined;
    }

    this.application.getControllerForElementAndIdentifier(this.element, 'pwa--capture')
      .media({ params: { constraints } });
  }

  start = ({detail}) => {
    console.error(detail);

    this.chunks = []
    this.startButtonTarget.setAttribute('hidden', '');
    this.downloadButtonTarget.setAttribute('hidden', '');
    this.stopButtonTarget.removeAttribute('hidden');
    this.destinationTarget.removeAttribute('hidden');
    this.destinationTarget.srcObject = new MediaStream(detail.stream.getTracks());
  }

  data = ({detail}) => {
    console.error(detail);
    if (detail.data.size <= 0) {
      return;
    }
    this.mimeType = detail.data.type;
    this.chunks.push(detail.data);
  }

  stop = () => {
    this.startButtonTarget.removeAttribute('hidden');
    this.destinationTarget.setAttribute('hidden', '');
    this.stopButtonTarget.setAttribute('hidden', '');
    this.destinationTarget.srcObject = null;
    if (this.chunks.length === 0) {
      return;
    }
    const extension = this.getExtensionFromMimeType();
    const filename = `recording.${extension}`;

    const file = new File(this.chunks, filename, {type: this.mimeType});
    this.downloadButtonTarget.href = URL.createObjectURL(file);
    this.downloadButtonTarget.removeAttribute('hidden');
    this.chunks = [];
  }

  getExtensionFromMimeType() {
    const baseType = this.mimeType.split(';')[0].trim();

    const map = {
      'video/webm': 'webm',
      'video/mp4': 'mp4',
      'video/ogg': 'ogv',
      'audio/webm': 'webm',
      'audio/ogg': 'ogg',
      'audio/mp4': 'm4a',
    };

    return map[baseType] || 'dat';
  }

  populateSources = async () => {
    const cameraStatus = await navigator.permissions.query({ name: 'camera' });
    const micStatus = await navigator.permissions.query({ name: 'microphone' });

    console.error('Camera:', cameraStatus.state);
    console.error('Microphone:', micStatus.state);

    const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
    stream.getTracks().forEach(track => track.stop());
    const devices = await navigator.mediaDevices.enumerateDevices();
    console.error(devices);

    this.populateAudioSources(devices);
    this.populateVideoSources(devices);
  }

  populateAudioSources = async (devices) => {
    if (!this.hasAudioSelectTarget) {
      return;
    }
    this.audioSelectTarget.innerHTML = '';

    for (const device of devices) {
      const option = document.createElement('option');
      option.value = device.deviceId;
      option.text = device.label || `${device.kind} (${device.deviceId})`;

      if (device.kind === 'audioinput') {
        this.audioSelectTarget.appendChild(option);
      }
    }
  }

  populateVideoSources = async (devices) => {
    if (!this.hasVideoSelectTarget) {
      return;
    }

    this.videoSelectTarget.innerHTML = '';

    for (const device of devices) {
      const option = document.createElement('option');
      option.value = device.deviceId;
      option.text = device.label || `${device.kind} (${device.deviceId})`;

      if (device.kind === 'videoinput' && this.hasVideoSelectTarget) {
        this.videoSelectTarget.appendChild(option);
      }
    }
  }

  getConstraints() {
    const audioSetting = this.hasAudioQualitySelectTarget ? this.audioQualitySelectTarget.value : null;
    const videoSetting = this.hasVideoQualitySelectTarget ? this.videoQualitySelectTarget.value : null;
    const frameRate = parseInt(this.hasFrameRateInputTarget ? this.frameRateInputTarget.value : '30', 10);

    const constraints = {
      audio: {},
      video: {},
    };

    if (audioSetting === 'studio') {
      constraints.audio = {
        sampleRate: 48000,
        channelCount: 2,
        echoCancellation: false
      };
    } else {
      constraints.audio = true;
    }

    switch (videoSetting) {
      case 'low':
        constraints.video = { width: 640, height: 360, frameRate };
        break;
      case 'medium':
        constraints.video = { width: 1280, height: 720, frameRate };
        break;
      case 'high':
        constraints.video = { width: 1920, height: 1080, frameRate };
        break;
      default:
        constraints.video = true;
    }

    return constraints;
  }
}
