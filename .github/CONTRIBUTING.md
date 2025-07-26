# Guide de Contribution

Tout d'abord, **merci** de vouloir contribuer à ce projet ! 🎉

## Signaler des Problèmes

Les bugs ou les demandes de fonctionnalités peuvent être signalés dans la section des issues GitHub du projet. Pour un rapport de bug efficace, merci d'inclure :

- La version du projet utilisée
- Les étapes pour reproduire le problème
- Le comportement attendu vs le comportement observé
- Tout message d'erreur pertinent

Exemple d'un bon rapport de bug :

```text
Version: 2.1.0 Description: L'upload d'images échoue sur Firefox
Étapes pour reproduire :
1. Aller sur la page /upload
2. Sélectionner une image .jpg
3. Cliquer sur "Envoyer"

Comportement attendu : L'image est uploadée et une URL est retournée Comportement actuel : Message d'erreur "Format non supporté"
Stack trace : [...]
```


## Standards de Code

Pour maintenir la qualité et la cohérence du code :

- Vous DEVEZ suivre les standards [PSR-12](http://www.php-fig.org/psr/psr-12/). Exemple :

```php
public function exemple(string $param): void {
 if ($param === '') {
  throw new InvalidArgumentException('Le paramètre ne peut pas être vide');
 }
 $this->faireQuelqueChose($param);
}
```

- Vous DEVEZ écrire des tests unitaires pour toute nouvelle fonctionnalité. Exemple :

```php
public function testExemple(): void {
 $this->expectException(InvalidArgumentException::class);
 $service = new MonService(); $service->exemple('');
}
```

- Vous DEVEZ documenter votre code avec des commentaires PHPDoc :

```php
/**
 * - Traite une image et retourne son URL.
 * -
 * - @param UploadedFile $file Le fichier image uploadé
 * - @return string L'URL de l'image traitée
 * - @throws ImageProcessingException Si le traitement échoue
 */
public function processImage(UploadedFile $file): string
```

## Processus de Contribution

1. **Fork & Clone**
   ```bash
   git clone https://github.com/votre-nom/projet.git
   cd projet
   ```

2. **Créer une Branche**
   ```bash
   git checkout -b feature/nouvelle-fonctionnalite
   # ou
   git checkout -b fix/correction-bug
   ```

3. **Commit**
   Écrivez des messages de commit clairs et descriptifs :
   ```bash
   # ❌ Mauvais
   git commit -m "fix"

   # ✅ Bon
   git commit -m "fix: Correction du timeout lors de l'upload d'images volumineuses"

4. **Pull Request**
    - Assurez-vous que votre branche est à jour avec la branche principale
    - Décrivez clairement vos modifications
    - Liez les issues concernées
    - Incluez des captures d'écran si pertinent

## Besoin d'Aide ?

- Consultez notre documentation
- Ouvrez une issue pour poser vos questions
- Rejoignez notre canal de discussion

⚠️ **Note de Sécurité** : Pour tout problème de sécurité, merci de NE PAS ouvrir d'issue publique. Contactez-nous directement via [contact@projet.com](mailto:contact@projet.com).
