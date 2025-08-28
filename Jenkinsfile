pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                // Клонируем код из репозитория
                checkout scm
            }
        }

        stage('Deploy to Kubernetes') {
            steps {
                script {
                    // Применяем все манифесты из папки
                    sh 'kubectl apply -f k8s-manifests/'
                    echo 'Развертывание запущено. Ожидание 60 секунд для стабилизации подов...'
                    // Даем время подам на запуск
                    sleep 60
                }
            }
        }

        stage('Verify Database Connection') {
            steps {
                script {
                    echo "Проверка доступности базы данных..."
                    // Получаем имя одного из подов приложения
                    def appPodName = sh(script: "kubectl get pods -l app=crudback -o jsonpath='{.items[0].metadata.name}'", returnStdout: true).trim()
                    if (appPodName) {
                        // Проверяем сетевое подключение к сервису БД 'db' на порту 3306 из пода приложения
                        sh "kubectl exec -it ${appPodName} -- bash -c \"timeout 10 bash -c '</dev/tcp/db/3306' && echo 'База данных MySQL доступна' || (echo 'Ошибка: база данных MySQL недоступна' && exit 1)\""
                    } else {
                        error "Под приложения не найден."
                    }
                }
            }
        }

        stage('Verify Frontend Availability') {
            steps {
                script {
                    echo "Проверка доступности веб-приложения..."
                    // Получаем внешний IP-адрес сервиса, назначенный MetalLB
                    def externalIp = sh(script: "kubectl get svc crudback-service -o jsonpath='{.status.loadBalancer.ingress[0].ip}'", returnStdout: true).trim()
                    if (externalIp) {
                        echo "Приложение доступно по адресу: http://${externalIp}"
                        // Проверяем, что приложение отвечает по HTTP
                        sh "curl --fail --silent http://${externalIp} || (echo 'Ошибка: веб-приложение недоступно по внешнему IP' && exit 1)"
                    } else {
                        error "Внешний IP для сервиса crudback-service не найден."
                    }
                }
            }
        }
    }
    post {
        success {
            echo 'Сборка успешно завершена!'
        }
        failure {
            echo 'Сборка провалена.'
        }
    }
}
