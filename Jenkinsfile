pipeline {
    agent any

    environment {
        KUBECONFIG = credentials('kubeconfig-secret-id')   // kubeconfig из Jenkins credentials
        MYSQL_PASSWORD = credentials('mysql-root-pass')    // пароль от БД (секрет)
    }

    stages {
        stage('Check Kubernetes') {
            steps {
                echo '🔍 Проверяем доступ к кластеру...'
                sh 'kubectl cluster-info'
                sh 'kubectl get nodes -o wide'
            }
        }

        stage('Test Database') {
            steps {
                echo '🔍 Проверяем доступ к БД...'
                sh '''
                    set -e
                    kubectl exec -n crud deploy/mysql-master -- \
                      mysqladmin ping -uroot -p$MYSQL_PASSWORD
                '''
            }
        }

        stage('Test Frontend') {
            steps {
                echo '🔍 Проверяем доступ к фронту...'
                sh '''
                    RESPONSE=$(curl -sSf http://192.168.0.100:80 || true)
                    if [ -z "$RESPONSE" ]; then
                      echo "❌ Фронт недоступен"
                      exit 1
                    fi
                    echo "✅ Фронт доступен"
                '''
            }
        }

        stage('Deploy Application') {
            steps {
                echo '🚀 Деплой приложения...'
                sh '''
                    kubectl apply -f k8s/
                    kubectl rollout status deployment/crudback-app -n crud
                    kubectl rollout status deployment/mysql-master -n crud
                    kubectl rollout status deployment/mysql-slave -n crud
                '''
            }
        }
    }

    post {
        success {
            echo "🎉 Деплой завершён успешно!"
        }
        failure {
            echo "❌ Ошибка в пайплайне!"
        }
    }
}
