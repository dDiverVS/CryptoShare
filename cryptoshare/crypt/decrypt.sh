#!/bin/bash
ficheroDestino=$1;
fichero=$ficheroDestino.crypt;
gpg --batch --yes --passphrase-fd 0 -o "$ficheroDestino" --passphrase-file /cryptoshare/crypt/.clave -d "$fichero";
