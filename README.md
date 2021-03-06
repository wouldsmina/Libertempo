 ![Logo](http://libertempo.tuxfamily.org/Logo-Libertempo.png)


[![BCH compliance](https://bettercodehub.com/edge/badge/libertempo/web?branch=develop)](https://bettercodehub.com/)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/ed902981f4fb40bda7b90c199a0b4da1)](https://www.codacy.com/app/libertempo/web)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/ed902981f4fb40bda7b90c199a0b4da1)](https://www.codacy.com/app/libertempo/web)
![build_status](https://travis-ci.org/libertempo/web.svg?branch=master)
[![licence](https://img.shields.io/badge/licence-GPL2-green.svg)](https://github.com/libertempo/web/blob/develop/LICENSE)

## Panthéon
[![](https://sourcerer.io/fame/prytoegrian/libertempo/web/images/0)](https://sourcerer.io/fame/prytoegrian/libertempo/web/links/0)[![](https://sourcerer.io/fame/prytoegrian/libertempo/web/images/1)](https://sourcerer.io/fame/prytoegrian/libertempo/web/links/1)[![](https://sourcerer.io/fame/prytoegrian/libertempo/web/images/2)](https://sourcerer.io/fame/prytoegrian/libertempo/web/links/2)[![](https://sourcerer.io/fame/prytoegrian/libertempo/web/images/3)](https://sourcerer.io/fame/prytoegrian/libertempo/web/links/3)[![](https://sourcerer.io/fame/prytoegrian/libertempo/web/images/4)](https://sourcerer.io/fame/prytoegrian/libertempo/web/links/4)[![](https://sourcerer.io/fame/prytoegrian/libertempo/web/images/5)](https://sourcerer.io/fame/prytoegrian/libertempo/web/links/5)[![](https://sourcerer.io/fame/prytoegrian/libertempo/web/images/6)](https://sourcerer.io/fame/prytoegrian/libertempo/web/links/6)[![](https://sourcerer.io/fame/prytoegrian/libertempo/web/images/7)](https://sourcerer.io/fame/prytoegrian/libertempo/web/links/7)

# Présentation

Libertempo est une application web interactive de gestion des congés du personnel. Elle a pour objectif de rendre la gestion des congés accessible à tous.

Libertempo se veut être au plus proche des règles inhérentes aux réglementations françaises tout en restant paramétrable afin de répondre aux particularités et conventions des entreprises et des administrations.

Plus d'informations sont disponibles sur le [blog](http://libertempo.tuxfamily.org) et la [documentation](http://libertempo.tuxfamily.org/Documentation).

# Initialisation
Avant tout, il vous faut installer `npm`, le [gestionnaire de paquet](https://www.npmjs.com/get-npm) de Node.

Ensuite, l'installation sous sa forme la plus simple se résume à faire :
```sh
git clone --single-branch -b master git@github.com:libertempo/web.git
cd web
ln -sf `pwd`/App/Tools/post-checkout .git/hooks/post-checkout
make install
```

Chaque nouvelle version est mise à disposition sur [github](https://github.com/libertempo/web/releases) et sur [le blog du logiciel](http://libertempo.tuxfamily.org/downloads/)

# Support minimum
| Logiciel | Version |
|-------|-----|
| php   | 7.1 |
| mysql | 8.0 |
| apache| 2.4 |

