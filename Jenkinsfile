pipeline {
    agent {
        kubernetes {
            yamlFile 'builder.yaml'
        }
    }

    stages {
        stage('Checkout Code') {
            steps {
                checkout scm
            }
        }

        stage('Test Database') {
            steps {
                container('kubectl') {
                    script {
                        echo 'Проверяем доступ к базе данных...'
                        // Проверка TCP соединения на MySQL через DNS-сервис
                        sh '''
                        timeout 5 bash -c "</dev/tcp/mysql-master.crud.svc.cluster.local/3306"  exit 1
                        '''
                    }
                }
            }
        }

        stage('Test Frontend') {
            steps {
                container('kubectl') {
                    script {
                        echo 'Проверяем доступ к фронтенду...'
                        // Проверка TCP соединения на фронтенд через DNS-сервис
                        sh '''
                        timeout 5 bash -c "</dev/tcp/crudback-service.crud.svc.cluster.local/8080"  exit 1
                        '''
                    }
                }
            }
        }

        stage('Deploy App to Kubernetes') {
            steps {
                container('kubectl') {
                    withCredentials([file(credentialsId: 'kubeconfig-secret-id', variable: 'KUBECONFIG')]) {
                        sh 'kubectl create ns crud || true'
                        sh 'kubectl apply -f ./manifests -n crud'
                    }
                }
            }
        }
    }

    post {
        failure {
            echo 'Ошибка в пайплайне!'
        }
    }
}
pipeline {
    agent {
        kubernetes {
            yamlFile 'builder.yaml'
        }
    }

    stages {
        stage('Checkout Code') {
            steps {
                checkout scm
            }
        }

        stage('Test Database') {
            steps {
                container('kubectl') {
                    script {
                        echo 'Проверяем доступ к базе данных...'
                        sh 'timeout 5 bash -c "echo > /dev/tcp/mysql-master.crud.svc.cluster.local/3306"  exit 1'
                    }
                }
            }
        }

        stage('Test Frontend') {
            steps {
                container('kubectl') {
                    script {
                        echo 'Проверяем доступ к фронтенду...'
                        sh 'timeout 5 bash -c "echo > /dev/tcp/crudback-service.crud.svc.cluster.local/8080"  exit 1'
                    }
                }
            }
        }

        stage('Deploy App to Kubernetes') {
            steps {
                container('kubectl') {
                    withCredentials([file(credentialsId: 'kubeconfig-secret-id', variable: 'KUBECONFIG')]) {
                        sh 'kubectl create ns crud || true'
                        sh 'kubectl apply -f ./manifests -n crud'
                    }
                }
            }
        }
    }

    post {
        failure {
            echo 'Ошибка в пайплайне!'
        }
    }
}
