pipeline {
    agent {
        kubernetes {
            yamlFile 'builder.yaml'
        }
    }

    stages {

        stage('Checkout SCM') {
            steps {
                checkout scm
            }
        }

        stage('Test Database') {
            steps {
                container('kubectl') {
                    script {
                        echo 'Проверяем доступ к базе данных...'
                        // Используем одинарные кавычки вокруг sh, чтобы Groovy не интерполировал $
                        sh 'timeout 5 bash -c "echo > /dev/tcp/$(kubectl get svc mysql-master -n crud -o jsonpath=\'{.spec.clusterIP}\')/3306"  exit 1'
                    }
                }
            }
        }

        stage('Test Frontend') {
            steps {
                container('kubectl') {
                    script {
                        echo 'Проверяем доступ к frontend...'
                        sh 'timeout 5 bash -c "echo > /dev/tcp/$(kubectl get svc crudback-service -n crud -o jsonpath=\'{.spec.clusterIP}\')/8080"  exit 1'
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
        success {
            echo 'Пайплайн успешно выполнен!'
        }
        failure {
            echo 'Ошибка в пайплайне!'
        }
    }
}
