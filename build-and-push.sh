#!/bin/bash
#
# Docker image build script
#
# Usage:
#    build_and_push.sh <php_version>
#
# Remarks:
#   php-version is directly related to a Dockerfile
#   If building for multiarch fails, with an error related to the Docker driver,
#   try this:
#      docker buildx create --name multiarch --driver docker-container
#      docker buildx use multiarch
#
# Author
#   Edward van der Jagt <edward@caret.net>
#

#
# Set some variables
#
GITLAB_BASE="gitlab-registry.caret.net/caret/internaltools/mongodb-php-gui"
IMG_VERSION="2.1"

#
# Now actually build and tag the image
#
# The provenance parameter is a workaround for an issue with Gitlab
# and multi-arch build (https://gitlab.com/gitlab-org/gitlab/-/issues/388865#workaround)
#
##docker buildx build --push --platform linux/arm64/v8,linux/amd64 --provenance=false -t $GITLAB_BASE:$IMG_VERSION -f Dockerfile .
docker build --push -t $GITLAB_BASE:$IMG_VERSION -f Dockerfile-staged .

#
# And push the image to the registry
#
cat <<EOFF

  Image creation done.
  To push to the registry, use:

     docker push     $GITLAB_BASE:$IMG_VERSION

EOFF

