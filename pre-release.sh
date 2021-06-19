#!/usr/bin/env bash

exitCode=0

MAN=`cat <<EOF
Вспомогательная утилита для сборки докер образов.
Использование: ./pre-release.sh [КЛЮЧ]
-Y                   параметр для 'тихой' сборки
-T, --token          токен для деплоя в docker-hub
    --login          логин для деплоя в docker-hub
    --namespace      пространство для деплоя в docker-hub
-N, --name           имя образа (например: php-sandbox-80)
-V, --version        версия образа (например: 0.0.1)
-D, --dockerfile     путь до Dockerfile
-C, --context        путь до папки контекста
-L, --label          создает отдельный лейбл который можно перезаписывать
EOF
`

POSITIONAL=()
while [[ $# -gt 0 ]]
do
key="$1"

case $key in
    -h|--help)
    echo -e "${MAN}"
    exit;
    ;;
    -Y)
    CONTINUE="y"
    shift # past argument
    ;;
    -T|--token)
    DEPLOY_TOKEN="$2"
    shift # past argument
    shift # past value
    ;;
    -V|--version)
    IMAGE_VERSION="$2"
    shift # past argument
    shift # past value
    ;;
    -D|--dockerfile)
    DOCKER_DOCKERFILE="$2"
    shift # past argument
    shift # past value
    ;;
    -C|--context)
    DOCKER_CONTEXT="$2"
    shift # past argument
    shift # past value
    ;;
    -L|--label)
    IMAGE_LABEL="$2"
    shift # past argument
    shift # past argument
    ;;
    --login)
    DEPLOY_LOGIN="$2"
    shift # past argument
    shift # past argument
    ;;
    --namespace)
    DEPLOY_NAMESPACE="$2"
    shift # past argument
    shift # past argument
    ;;
    -N|--name)
    IMAGE_NAME="$2"
    shift # past argument
    shift # past argument
    ;;
    *)    # unknown option
    POSITIONAL+=("$1") # save it in an array for later
    echo -e "unknown option"
    exit;
    ;;
esac
done
set -- "${POSITIONAL[@]}" # restore positional parameters

if [[ -n $1 ]]; then
    echo "Last line of file specified as non-opt/last argument:"
    tail -1 "$1"
fi

base_dir=${PWD}

[[ ! -z ${DEPLOY_TOKEN} ]] && deploy_token=${DEPLOY_TOKEN} || { echo "Error! Set the token for push in hub." ; exit 1; }
[[ ! -z ${IMAGE_VERSION} ]] && image_version=${IMAGE_VERSION} || { echo "Error! Set the version of the image." ; exit 1; }
[[ ! -z ${IMAGE_NAME} ]] && image_name=${IMAGE_NAME} || { echo "Error! Set the name of the image." ; exit 1; }
[[ ! -z ${DOCKER_DOCKERFILE} ]] && docker_dockerfile=${DOCKER_DOCKERFILE} || { echo "Error! Set the path to Dockerfile" ; exit 1; }
[[ ! -z ${DOCKER_CONTEXT} ]] && docker_context=${DOCKER_CONTEXT} || docker_context="."
[[ ! -z ${IMAGE_LABEL} ]] && image_label=${IMAGE_LABEL} || docker_label="latest"
[[ ! -z ${DEPLOY_LOGIN} ]] && deploy_login=${DEPLOY_LOGIN} || deploy_login="eldarco"
[[ ! -z ${DEPLOY_NAMESPACE} ]] && deploy_namespace=${DEPLOY_NAMESPACE} || deploy_namespace="eldarco/code-try"

SETTINGS=`cat <<EOF
pre-release.sh will create docker image and push to pub. Are you sure?
DEPLOY_TOKEN = "${deploy_token}"
DEPLOY_LOGIN = "${deploy_login}"
DEPLOY_NAMESPACE = "${deploy_namespace}"
IMAGE_NAME = "${image_name}"
IMAGE_VERSION = "${image_version}"
IMAGE_LABEL = "${image_label}"
DOCKER_DOCKERFILE = "${docker_dockerfile}"
DOCKER_CONTEXT = "${docker_context}"

Enter Y or N...
EOF
`

echo -e "${SETTINGS}"

[[ ! -z $CONTINUE ]] && echo "Selected silent mode!!! Press ctrl+c for reject" || read -n 1 CONTINUE

[[ ! ${CONTINUE} =~ ^[Yy]$ ]] && { sleep 3; echo " "; echo "EXIT"; exit 1; }
sleep 3;
echo ""
echo "DO"


echo "$deploy_token" | docker login --username "$deploy_login" --password-stdin
if ! docker build --compress -t "$deploy_namespace":"$image_name"-"$image_version" -f "$docker_dockerfile" "$docker_context"; then
  exitCode=1
  exit $exitCode
fi;
docker tag "$deploy_namespace":"$image_name"-"$image_version" "$deploy_namespace":"$image_name"-"$image_label"
docker push "$deploy_namespace":"$image_name"-"$image_version"
docker push "$deploy_namespace":"$image_name"-"$image_label"

exit $exitCode

