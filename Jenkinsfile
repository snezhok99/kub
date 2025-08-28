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
                        // Простая проверка, что MySQL слушает порт
                        sh 'kubectl exec -n crud deploy/mysql-master -- bash -c "mysqladmin ping -uroot -p$MYSQL_ROOT_PASSWORD"'
                    }
                }
            }
        }

        stage('Test Frontend') {
            steps {
                container('kubectl') {
                    script {
                        echo 'Проверяем доступ к фронтенду...'
                        // Простая проверка, что фронтенд возвращает HTTP 200
                        sh 'kubectl exec -n crud deploy/frontend -- curl -s -o /dev/null -w "%{http_code}" http://localhost:8080 | grep 200'
                    }
                }
            }
        }

        stage('Deploy App to Kubernetes') {
            steps {
                container('kubectl') {
                    // НЕ трогаем деплой, оставляем рабочий
                    sh 'kubectl apply -f ./manifests -n crud'
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
