# load the library 
library(dplyr)
library(MASS)
library(ggplot2)
library(mice)
library(purrr)

recipe_v1 <- read.csv('C:/Users/xzang/Desktop/UIUC_CS/CS411_DatabaseSystem/project_data/score_data.csv')

#############################################
## Pre-processing 
##############################################
# Step 1. missing data randomness check
# missing data check 
miss_impute <- function(data){
  
  missingValue <- aggr(data)
  missingSheet <- print(missingValue)
  missingSheet$missing_perc <- (missingSheet$Count/nrow(data))*100
  missingSheet <- missingSheet %>% arrange(desc(missing_perc))
  
  print(missingSheet)
  
}

missingValue <- aggr(recipe_v1)

# predicted mean matching imputation
init = mice(data = recipe_v1, maxit = 0) # the number of iterations, default is 5
imp1 <- complete(init)

# Step 2. floor and cap outliers
floor_cap_variables <- function(raw_data){
  numerics <- colnames(raw_data %>% keep(~is.numeric(.x) | is.integer(.x)))
  for(col in numerics){
    quantiles <- quantile(raw_data[,col], probs = c(.25, .75), na.rm = T)
    caps <- quantile(raw_data[,col], probs = c(.05, .95), na.rm = T)
    range <- 1.5*IQR(raw_data[,col], na.rm = T)
    raw_data[col][raw_data[col] < (quantiles[1] - range)] <- caps[1]
    raw_data[col][raw_data[col] > (quantiles[2] + range)] <- caps[2]
  }
  return(raw_data)
} 

df1 <- floor_cap_variables(recipe_v1)

# check the variable distribution 
lapply(df1, function(x) summary(x))

# visualize the data performance
ggplot(data = melt(df1[,-2]), mapping = aes(x = value)) + 
  geom_histogram(bins = 10) + facet_wrap(~variable, scales = 'free')


###########################################
# Data Partition
###########################################
#Random sampling 
samplesize = 0.70*nrow(df1)
set.seed(99) 
index = sample(seq_len(nrow(df1)), size = samplesize)
#Creating training and test set 
df_train = df1[index,]
df_test = df1[-index,]

###########################################
# simple linear regression
############################################
library(caret)
set.seed(99)
# cross-validation on train
myControl_regression <- trainControl(
  method = 'cv', 
  number = 5
)

# simple linear regression in caret
lm_model1 <- train(
  rating ~ ., 
  data = df_train %>% dplyr::select(-recipe_id, -title),
  method = "lm",
  metric = 'RMSE',
  trControl = myControl_regression
)

# print model 
summary(lm_model1)

# Predict on full data: p
pred <- predict(lm_model1, df_test)

df_score <- cbind(df_test,pred)

## out-sample (test) RMSE for linear regression
# Compute errors: error
error <- pred - df_test[["rating"]]

# Calculate RMSE (in-sample RMSE)
sqrt(mean(error^2))

####################################################################################
# END 
####################################################################################


