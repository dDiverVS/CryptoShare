#!/bin/bash
fichero=$1;
ficheroDestino=$fichero.crypt;
gpg --batch --yes --encrypt -o "$ficheroDestino" --recipient 01A2F3FA "$fichero";
