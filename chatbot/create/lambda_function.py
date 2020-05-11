from __future__ import print_function
from urllib.request import Request, urlopen
import neo4j
from neo4j.v1 import GraphDatabase, basic_auth
import json

url = "bolt://ec2-54-160-22-105.compute-1.amazonaws.com"
def lambda_handler(event,context):
    results = []
    recipe = event['currentIntent']['slots']['recipe']
    i=[""] * 6   
    i[0] = event['currentIntent']['slots']['ione'].strip()
    i[1] = event['currentIntent']['slots']['itwo'].strip()
    i[2] = event['currentIntent']['slots']['iFour'].strip()
    i[3] = event['currentIntent']['slots']['iFive'].strip()
   
    driver = GraphDatabase.driver(url, auth=basic_auth("neo4j", "i-0920a3a98b16e7ac2"), encrypted=False)
    session = driver.session()
    
    #Explicit Transactions

    def create_r_node(tx):
        return tx.run("CREATE (m:Recipes{recipeName:'"+recipe+"'}) return id(m)").single().value()
        
    def search_i_node(tx, iname):
        return tx.run("MATCH(i:Ingredients) WHERE i.ingredientName = '"+iname+"' RETURN id(i)").single().value()
        
    def set_relationship(tx, node_id, i_id):
        return tx.run("MATCH (m:Recipes) WHERE id(m) ="+str(node_id)+" MATCH(i:Ingredients) WHERE id(i)=" + str(i_id)+" CREATE (m)-[:IS_MADE_OF]->(i) return i.ingredientName" ).single().value()
        
    with driver.session() as session:
        tx = session.begin_transaction()
        node_id = create_r_node(tx)
        print(node_id)
        for j in range(4):
            if len(i[j])>0:
                
                i_id = search_i_node(tx, i[j])
                print(i_id)
                s=set_relationship(tx, node_id, i_id)   
                print(s)
        tx.commit()

    response =  {"dialogAction":{"fulfillmentState":"Fulfilled","type":"Close","message": {"contentType":"PlainText", "content": "The new "+recipe +" has been added to DB!" }   }    }    
    return response